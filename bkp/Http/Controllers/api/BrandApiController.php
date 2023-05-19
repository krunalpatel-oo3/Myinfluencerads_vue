<?php

namespace App\Http\Controllers\api;

use App\Models\ProjectImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Config;
use App\CustomFunction\CustomFunction;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\CMSItem;
use App\Models\Category;
use App\Models\Platform;
use App\Models\Product;
use App\Models\Project;
use App\Models\Brand;
use App\Models\Education;
use App\Models\CustomLine;
use App\Models\ProjectProduct;
use App\Models\ProjectTagTagged;
use App\Models\Skill;
use App\Models\Tag;
use App\Models\UserPortfolio;
use App\Models\UserPortfolioImage;
use App\Models\UserPortfolioSkill;
use App\Models\ProjectPlatform;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Models\BrandImage;
use App\Models\BrandProduct;
use App\Models\BrandCategory;
use Illuminate\Support\Facades\DB;
use App\Models\PlanUserAssoc;
use App\Helpers\ResponseTrait;
use App\Helpers\CommonTrait;
use Exception;

class BrandApiController extends BaseController {

    use ResponseTrait;
    use CommonTrait;

    /**
     */
    function __construct() {
        
    }

    /**
     * IN USE
     * Get brand details
     * @param Request $request
     * @param type $Brand_slug
     * @return type
     */
    public function detail(Request $request, $Brand_slug) {
        try {
            $default_user_avatar_url = config('app.empty_default_user_avatar_url');
            $brandData = Brand::getBySlug($Brand_slug)
                    // ->getByStatus('A')
                    ->with('creator:id,full_name,profile_photo,location,title,login')
                    ->with('categoryName')
                    ->get()
                    ->map(function ($brandData) use ($default_user_avatar_url) {
                        $userProfilePhotoImageProps = ['image_url' => $default_user_avatar_url];
                        if (!empty($brandData->creator->profile_photo)) {
                            $userProfilePhotoImageProps = User::readUserImageProps($brandData->creator['id'], $brandData->creator['profile_photo'] ?? $default_user_avatar_url, true);
                            if (empty($userProfilePhotoImageProps['image_url'])) {
                                $userProfilePhotoImageProps['image_url'] = $default_user_avatar_url;
                            }
                        }
                        $brandData['creatorUserProfilePhotoImageProps'] = $userProfilePhotoImageProps;

                        parse_str(parse_url($brandData->link_youtube, PHP_URL_QUERY), $my_array_of_vars);
                        if (isset($my_array_of_vars['v'])) {
                            $brandData->youtube_id = "https://www.youtube.com/embed/" . $my_array_of_vars['v'];
                        }

                        return $brandData;
                    })
                    ->first();

            if (empty($brandData)) {
                throw new Exception('brand slug : ' . $Brand_slug . ' not found !');
            }
            $brand_image_logo = DB::table('brand_image')
                            ->where('brand_image.brand_id', $brandData->id)
                            ->where('brand_image.type', 'logo')
                            ->orderBy('brand_image.id', 'DESC')
                            ->get()
                            ->map(function ($brandImageItem) {
                                // dd($brandImageItem->filename);
                                $brandImageItem->is_main_label = BrandImage::getIsMainLabel($brandImageItem->is_main);
                                $brandImageItem->created_at_formatted = getCFFormattedDateTime($brandImageItem->created_at);
                                $brandImageItemImgProps = BrandImage::readBrandImageProps($brandImageItem->brand_id, $brandImageItem->filename, true);
                                if (!empty($brandImageItemImgProps)) {
                                    $brandImageItem->projectImagePropsArray = $brandImageItemImgProps;
                                }
                                return $brandImageItem;
                            })->first();
            $brand_image = DB::table('brand_image')
                            ->where('brand_image.brand_id', $brandData->id)
                            ->where('brand_image.type', 'image')
                            ->orderBy('brand_image.id', 'DESC')
                            ->get()
                            ->map(function ($brandImageItem) {
                                // dd($brandImageItem->filename);
                                $brandImageItem->is_main_label = BrandImage::getIsMainLabel($brandImageItem->is_main);
                                $brandImageItem->created_at_formatted = getCFFormattedDateTime($brandImageItem->created_at);
                                $brandImageItemImgProps = BrandImage::readBrandImageProps($brandImageItem->brand_id, $brandImageItem->filename, true);
                                if (!empty($brandImageItemImgProps)) {
                                    $brandImageItem->projectImagePropsArray = $brandImageItemImgProps;
                                }
                                return $brandImageItem;
                            })->all();

            $brand_pdf = DB::table('brand_image')
                            ->where('brand_image.brand_id', $brandData->id)
                            ->where('brand_image.type', 'pdf')
                            ->orderBy('brand_image.id', 'DESC')
                            ->get()
                            ->map(function ($brandPdfItem) {
                                //dd($brandPdfItem);
                                $brandPdfItem->is_main_label = BrandImage::getIsMainLabel($brandPdfItem->is_main);
                                $brandPdfItem->created_at_formatted = getCFFormattedDateTime($brandPdfItem->created_at);
                                $brandPdfItemImgProps = BrandImage::readBrandPdfProps($brandPdfItem->brand_id, $brandPdfItem->filename, true);
                                //   dd($brandPdfItemImgProps);
                                if (!empty($brandPdfItemImgProps)) {
                                    $brandPdfItem->projectPdfPropsArray = $brandPdfItemImgProps;
                                }
                                return $brandPdfItem;
                            })->all();
            $brandproductCount = \App\Models\BrandProduct
                    ::where('brand_id', $brandData->id)
                    ->count();
            
            $brand_products = BrandProduct::select('product.*', 'brand_product.id as id', 'product_images.image_name')
                            ->join('product', 'product.id', '=', 'brand_product.product_id')
                            ->leftJoin('product_images', 'product.id', '=', 'product_images.product_id')
                            ->where('brand_product.brand_id', $brandData->id)
                            ->get()->all();

            $brandData->published_at_formatted = getCFFormattedDate($brandData->published_at);
            
            return $this->success(['brand' => $brandData, 'brand_image_logo' => $brand_image_logo,
                        'brandproductcount' => $brandproductCount, 'brand_image' => $brand_image,
                        'brand_pdf' => $brand_pdf, 'brand_products' => $brand_products
                            ], "Brand detail");
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }

    //Route::post('/getProjectsList/{page}', [ProjectApiController::class, 'getProjectsList']);

    public function getBrandListPublic(Request $request) {
        $currpage = 1;
        if (isset($request->currpage) && $request->currpage != "" && is_numeric($request->currpage)) {
            $currpage = $request->currpage;
        }

        $user_details = User::getLoggedInUserDetails();
        $user_id = $user_details['id'];

        $record_per_page_all = Config::get('constant.record_per_page');
        $record_per_page = $record_per_page_all['project'];

        $list = Project::getListAllApi($currpage, $record_per_page, $user_id);
        $code = 0;
        $total_page = 1;
        if (!empty($list)) {
            if (!empty($list['data'])) {
                $code = 1;
                $total_page = $list['total_page'];
                $list = $list['data'];
            }
        }

        return response()->json(['data' => $list, 'code' => $code, 'total_page' => $total_page]);
    }

    /**
     * User brand list
     * @param Request $request
     * @return type
     */
    public function getBrandList(Request $request) {
        try {
            $user_details = User::getLoggedInUserDetails();
            $user_id = $user_details['id'];

            $list = Brand::where(['user_id' => $user_id, 'is_deleted' => 0])->orderBy('name','ASC')->get()->all();
            return $this->success(['brands' => $list], "Brand list");
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }

    /**
     * create brand
     * @param Request $request
     * @return type
     */
    public function publishBrand(Request $request) {
        try {
            DB::beginTransaction();
            $user_details = User::getLoggedInUserDetails();
            $this->checkIfUserIsPermitted($user_details, 'BRAND');

            if (!isset($request->name) || $request->name == "" || $request->name == null) {
                throw new Exception('Please enter the Brand name');
            }

            if (!isset($request->category_id) || $request->category_id == "" ||  $request->category_id == "undefined") {
                throw new Exception('Please select the category');
            }

            if(!empty($request->web_url) && !filter_var($request->web_url, FILTER_VALIDATE_URL)) {
                throw new Exception('Please enter the valid URL for Brand website');
            }
            
            if(!empty($request->facebook_url) && !filter_var($request->facebook_url, FILTER_VALIDATE_URL)) {
                throw new Exception('Please enter the valid URL for Brand facebook page');
            }
            
            if(!empty($request->youtube_url) && !filter_var($request->youtube_url, FILTER_VALIDATE_URL)) {
                throw new Exception('Please enter the valid URL for youtube');
            }
            
            if(!empty($request->youtube_page) && !filter_var($request->youtube_page, FILTER_VALIDATE_URL)) {
                throw new Exception('Please enter the valid URL for youtube page');
            }

            $isBrandavailable = Brand::where([['name','=',$request->name],['user_id','=',$user_details['id']],['is_deleted','=',0]])->exists();
            if($isBrandavailable){
                throw new Exception('The brand is already exist. Please try again with new one!');
            }

            $newBrand = new Brand();
            $newBrand->name = $request->name;
            $newBrand->desc = $request->brand_desc;
            $newBrand->web_url = $request->web_url;
            $newBrand->youtube_url = $request->youtube_url;
            $newBrand->facebook_url = $request->facebook_url;
            $newBrand->user_id = (int) $user_details['id'];
            $newBrand->save();

            $ImageUploadFileLogo = $request->file('file_logo');

            if (!empty($ImageUploadFileLogo)) {
                $data = date('Y/m/d');
                $hour = date('H');
                $path = 'brand/images/' . $data . '/' . $hour . '-' . $newBrand->id;
                $brand_image_file_path = imageuploads3($path, $ImageUploadFileLogo);
                //store in db
                $brandImamge = new BrandImage();
                $brandImamge->brand_id = $newBrand->id;
                $brandImamge->filename = $brand_image_file_path;
                $brandImamge->is_main = 0;
                $brandImamge->type = 'logo';
                $brandImamge->info = '';
                $brandImamge->save();
            }

            for ($x = 0; $x < $request->image_files_count; $x++) {
                $file_caption_ = 'file_image_caption_' . $x;
                $file_ismain_ = 'file_ismain_' . $x;
                $ImageUploadFile = $request->file('file_' . $x);
                $file_ismain = 0;
                if ($request->$file_ismain_ == 'true') {
                    $file_ismain = 1;
                }
                $file_caption = $request->$file_caption_;

                if (!empty($ImageUploadFile)) {
                    $data = date('Y/m/d');
                    $hour = date('H');
                    $path = 'brand/images/' . $data . '/' . $hour . '-' . $newBrand->id;
                    $brand_image_file_path = imageuploads3($path, $ImageUploadFile);
                    //store in db
                    $brandImamge = new BrandImage();
                    $brandImamge->brand_id = $newBrand->id;
                    $brandImamge->filename = $brand_image_file_path;
                    $brandImamge->is_main = $file_ismain;
                    $brandImamge->info = $file_caption;
                    $brandImamge->save();
                }
            }
            //pdf upload
            for ($i = 0; $i < $request->pdf_files_count; $i++) {
                $file_pdf_caption_ = 'file_pdf_caption_' . $i;
                $PdfUploadFile = $request->file('file_pdf_' . $i);
                $Pdfcaption = $request->$file_pdf_caption_;

                if (!empty($PdfUploadFile)) {
                    $data = date('Y/m/d');
                    $hour = date('H');
                    $path = 'brand/images/' . $data . '/' . $hour . '-' . $newBrand->id;
                    $brand_pdf_file_path = imageuploads3($path, $PdfUploadFile);
                    //store in db
                    $brandImamge = new BrandImage();
                    $brandImamge->brand_id = $newBrand->id;
                    $brandImamge->filename = $brand_pdf_file_path;
                    $brandImamge->type = 'pdf';
                    $brandImamge->info = $Pdfcaption;
                    $brandImamge->save();
                }
            }

            if (isset($request->category_id)) {
                $bcat = new BrandCategory();
                $bcat->brand_id = $newBrand->id;
                $bcat->category_id = $request->category_id;
                $bcat->save();
            }

            $request_product = json_decode($request->product, true);
            if (isset($request->product)) {
                foreach ($request_product as $product) {
                    $bPro = new BrandProduct();
                    $bPro->brand_id = $newBrand->id;
                    $bPro->product_id = $product['id'];
                    $bPro->save();
                }
            }
            DB::commit();

            return $this->success(['id' => $newBrand->id, 'slug' => $newBrand->slug], "Brand has added successfully");
        } catch (Exception $ex) {
            DB::rollback();
            return $this->error($ex->getMessage());
        }
    }

    /**
     * Update brand
     * @param Request $request
     * @return type
     * @throws Exception
     */
    public function updateBrand(Request $request) {
        try {
            DB::beginTransaction();
            $user_details = User::getLoggedInUserDetails();
            $this->checkIfUserIsPermitted($user_details, 'BRAND');
            
            if(!empty($request->web_url) && !filter_var($request->web_url, FILTER_VALIDATE_URL)) {
                throw new Exception('Website link is not correct url');
            }
            
            if(!empty($request->facebook_url) && !filter_var($request->facebook_url, FILTER_VALIDATE_URL)) {
                throw new Exception('Facebook link is not correct url');
            }
            
            if(!empty($request->youtube_url) && !filter_var($request->youtube_url, FILTER_VALIDATE_URL)) {
                throw new Exception('Youtube link is not correct url');
            }
            
            if(!empty($request->youtube_page) && !filter_var($request->youtube_page, FILTER_VALIDATE_URL)) {
                throw new Exception('Youtube page link 2 is not correct url');
            }

            $newBrand = Brand::where('id', $request->id)->first();
            $newBrand->name = $request->name;
            $newBrand->desc = $request->brand_desc;
            $newBrand->web_url = $request->web_url;
            $newBrand->youtube_url = $request->youtube_url;
            $newBrand->facebook_url = $request->facebook_url;
            $newBrand->user_id = (int) $user_details['id'];
            $newBrand->save();

            $ImageUploadFileLogo = $request->file('file_logo');

            if (!empty($ImageUploadFileLogo)) {
                $data = date('Y/m/d');
                $hour = date('H');
                $path = 'brand/images/' . $data . '/' . $hour . '-' . $newBrand->id;
                $brand_image_file_path = imageuploads3($path, $ImageUploadFileLogo);

                $brandImamge = new BrandImage();
                $brandImamge->brand_id = $newBrand->id;
                $brandImamge->filename = $brand_image_file_path;
                $brandImamge->is_main = 0;
                $brandImamge->type = 'logo';
                $brandImamge->info = '';
                $brandImamge->save();
            }

            for ($x = 0; $x < $request->image_files_count; $x++) {
                $file_caption_ = 'file_image_caption_' . $x;
                $file_ismain_ = 'file_ismain_' . $x;
                $ImageUploadFile = $request->file('file_' . $x);
                $file_ismain = 0;
                if ($request->$file_ismain_ == 'true') {
                    $file_ismain = 1;
                }
                $file_caption = $request->$file_caption_;


                if (!empty($ImageUploadFile)) {
                    $data = date('Y/m/d');
                    $hour = date('H');
                    $path = 'brand/images/' . $data . '/' . $hour . '-' . $newBrand->id;
                    $brand_image_file_path = imageuploads3($path, $ImageUploadFile);

                    $brandImamge = new BrandImage();
                    $brandImamge->brand_id = $newBrand->id;
                    $brandImamge->filename = $brand_image_file_path;
                    $brandImamge->is_main = $file_ismain;
                    $brandImamge->info = $file_caption;
                    $brandImamge->save();
                }
            }
            //pdf upload
            for ($i = 0; $i < $request->pdf_files_count; $i++) {
                $file_pdf_caption_ = 'file_pdf_caption_' . $i;
                $PdfUploadFile = $request->file('file_pdf_' . $i);
                $Pdfcaption = $request->$file_pdf_caption_;
                // dd($Pdfcaption);
                if (!empty($PdfUploadFile)) {

                    $data = date('Y/m/d');
                    $hour = date('H');
                    $path = 'brand/images/' . $data . '/' . $hour . '-' . $newBrand->id;
                    $brand_pdf_file_path = imageuploads3($path, $PdfUploadFile);

                    $brandImamge = new BrandImage();
                    $brandImamge->brand_id = $newBrand->id;
                    $brandImamge->filename = $brand_pdf_file_path;
                    $brandImamge->type = 'pdf';
                    $brandImamge->info = $Pdfcaption;
                    $brandImamge->save();
                }
            }

            if (isset($request->category_id)) {
                BrandCategory::where('brand_id', $request->id)->delete();
                $bcat = new BrandCategory();
                $bcat->brand_id = $newBrand->id;
                $bcat->category_id = $request->category_id;
                $bcat->save();
            }

            $request_product = json_decode($request->product, true);
            if (isset($request->product)) {
                BrandProduct::where('brand_id', $request->id)->delete();
                foreach ($request_product as $product) {
                    $bPro = new BrandProduct();
                    $bPro->brand_id = $newBrand->id;
                    $bPro->product_id = $product['id'];
                    $bPro->save();
                }
            }
            DB::commit();

            return $this->success(['id' => $newBrand->id, 'slug' => $newBrand->slug], "Brand has been updated successfully");
        } catch (Exception $ex) {
            DB::rollback();
            return $this->error($ex->getMessage());
        }
    }

    /**
     * Delete brand resource image/file
     * @param Request $request
     * @return type
     */
    public function DeleteBrandImage(Request $request) {
        try {
            $user_details = User::getLoggedInUserDetails();
            $this->checkIfUserIsPermitted($user_details, 'BRAND');
            
            BrandImage::where('brand_id', $request->brand_id)->where('id', $request->id)->delete();

            return $this->success(null, "Brand resource has been deleted successfully");
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }

    /**
     * Delete brand
     * @param Request $request
     * @return type
     */
    public function DeleteBrand(Request $request) {
        try {
            $user_details = User::getLoggedInUserDetails();
            $this->checkIfUserIsPermitted($user_details, 'BRAND');
            
            Brand::where('id', $request->id)->update(['is_deleted' => 1]);

            return $this->success(null, "Brand has been deleted successfully");
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }

}
