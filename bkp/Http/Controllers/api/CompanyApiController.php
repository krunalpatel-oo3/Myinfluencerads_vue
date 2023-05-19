<?php

namespace App\Http\Controllers\api;

use Illuminate\Routing\Controller as BaseController;
use App\Models\Brand;
use App\Models\CompanyImage;
use App\Models\Company;
use App\Models\CompanyBrand;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\{Project, ProjectImage};
use App\Models\ProjectCompany;
use App\Models\User;
use App\Models\PlanUserAssoc;
use App\Helpers\ResponseTrait;
use App\Helpers\CommonTrait;
use Exception;
use Config;

class CompanyApiController extends BaseController {

    use ResponseTrait;
    use CommonTrait;

    /**
     */
    function __construct() {
        
    }

    /**
     * Company detail
     * @param Request $request
     * @param type $Company_slug
     * @return type
     */
    public function detail(Request $request, $Company_slug)
    {
        try {
            $default_user_avatar_url = config('app.empty_default_user_avatar_url');
            $companyData = Company
                ::getBySlug($Company_slug)
                // ->getByStatus('A')
                ->with('creator:id,full_name,profile_photo,location,title,login')
                // ->with('brand')
                // ->with('plateform')
                ->get()
                ->map(function ($companyData) use ($default_user_avatar_url) {
                    $userProfilePhotoImageProps = ['image_url' => $default_user_avatar_url];
                    if (!empty($companyData->creator->profile_photo)) {
                        $userProfilePhotoImageProps = User::readUserImageProps($companyData->creator['id'], $companyData->creator['profile_photo'] ?? $default_user_avatar_url, true);
                        if (empty($userProfilePhotoImageProps['image_url'])) {
                            $userProfilePhotoImageProps['image_url'] = $default_user_avatar_url;
                        }
                    }
                    $companyData['creatorUserProfilePhotoImageProps'] = $userProfilePhotoImageProps;

                    parse_str(parse_url($companyData->link_youtube, PHP_URL_QUERY), $my_array_of_vars);
                    if (isset($my_array_of_vars['v'])) {
                        $companyData->youtube_id = "https://www.youtube.com/embed/" . $my_array_of_vars['v'];
                    }
                    $companyData['brand'] = DB::table('company_brand')
                            ->join('brand', 'brand.id', '=', 'company_brand.brand_id')
                            ->join('brand_image', 'brand_image.brand_id', '=', 'brand.id')
                            ->where('company_brand.company_id', $companyData->id)
                            ->where('brand_image.type', 'logo')
                            ->get()->all();
                    return $companyData;
                })
                ->first();

        if (empty($companyData)) {
            throw new Exception('company slug : ' . $company_slug . ' not found !');
        }
        $company_image_logo = DB::table('company_image')
                        ->where('company_image.company_id', $companyData->id)
                        ->where('company_image.type', 'logo')
                        ->orderBy('company_image.id', 'DESC')
                        ->get()
                        ->map(function ($companyImageItem) {
                            // dd($companyImageItem->filename);
                            $companyImageItem->is_main_label = CompanyImage::getIsMainLabel($companyImageItem->is_main);
                            $companyImageItem->created_at_formatted = getCFFormattedDateTime($companyImageItem->created_at);
                            $companyImageItemImgProps = CompanyImage::readCompanyImageProps($companyImageItem->company_id, $companyImageItem->filename, true);
                            if (!empty($companyImageItemImgProps)) {
                                $companyImageItem->projectImagePropsArray = $companyImageItemImgProps;
                            }
                            return $companyImageItem;
                        })->first();
        $company_image = DB::table('company_image')
                        ->where('company_image.company_id', $companyData->id)
                        ->where('company_image.type', 'image')
                        ->orderBy('company_image.id', 'DESC')
                        ->get()
                        ->map(function ($companyImageItem) {
                            // dd($companyImageItem->filename);
                            $companyImageItem->is_main_label = CompanyImage::getIsMainLabel($companyImageItem->is_main);
                            $companyImageItem->created_at_formatted = getCFFormattedDateTime($companyImageItem->created_at);
                            $companyImageItemImgProps = CompanyImage::readCompanyImageProps($companyImageItem->company_id, $companyImageItem->filename, true);
                            if (!empty($companyImageItemImgProps)) {
                                $companyImageItem->projectImagePropsArray = $companyImageItemImgProps;
                            }
                            return $companyImageItem;
                        })->all();

        $company_pdf = DB::table('company_image')
                        ->where('company_image.company_id', $companyData->id)
                        ->where('company_image.type', 'pdf')
                        ->orderBy('company_image.id', 'DESC')
                        ->get()
                        ->map(function ($companyPdfItem) {
                            //dd($companyPdfItem);
                            $companyPdfItem->is_main_label = CompanyImage::getIsMainLabel($companyPdfItem->is_main);
                            $companyPdfItem->created_at_formatted = getCFFormattedDateTime($companyPdfItem->created_at);
                            $companyPdfItemImgProps = CompanyImage::readCompanyPdfProps($companyPdfItem->company_id, $companyPdfItem->filename, true);
                            //   dd($companyPdfItemImgProps);
                            if (!empty($companyPdfItemImgProps)) {
                                $companyPdfItem->projectPdfPropsArray = $companyPdfItemImgProps;
                            }
                            return $companyPdfItem;
                        })->all();
        $ComapnyProjectCount = ProjectCompany
                ::where('company_id', $companyData->id)
                ->count();
        $ProjectCompany = ProjectCompany::select('project.*', 'project_company.id as id', 'project_company.project_id as project_id')
                        ->join('project', 'project.id', '=', 'project_company.project_id')
                        ->where('company_id', $companyData->id)
                        ->get()->all();

        foreach ($ProjectCompany as $key => $value) {
            $getProjectImage = ProjectImage::where([['project_id', "=", $value->project_id],['type', "=", 'image']])->pluck('filename');
            $value->filename = !empty($getProjectImage) && count($getProjectImage) > 0 ? $getProjectImage[0] : ""; 
        }

        $companyData->published_at_formatted = getCFFormattedDate($companyData->published_at);

        return $this->success([
                    'company' => $companyData,
                    'company_image_logo' => $company_image_logo,
                    'comapnyprojectcount' => $ComapnyProjectCount,
                    'company_image' => $company_image,
                    'company_pdf' => $company_pdf,
                    'ProjectCompany' => $ProjectCompany,
                        ], "Detail");
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }        
    }

    /**
     * Company list
     * @param Request $request
     * @return type
     */
    public function getCompanyListPublic(Request $request)
    {
        try {
            $currpage = 1;
            if (isset($request->currpage) && $request->currpage != "" && is_numeric($request->currpage)) {
                $currpage = $request->currpage;
            }

            $user_details = User::getLoggedInUserDetails();
            $user_id = $user_details['id'];

            $record_per_page_all = Config::get('constant.record_per_page');
            $record_per_page = $record_per_page_all['project'];

            $list = Company::getListAllApi($currpage, $record_per_page);

            $total_page = 1;
            if (!empty($list)) {
                if (!empty($list['data'])) {
                    $total_page = $list['total_page'];
                    $list = $list['data'];
                }
            }

            return $this->success(['companys' => $list, 'total_page' => $total_page], 'List');
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }

    /**
     * Create Company
     * @param Request $request
     * @return type
     */
    public function publishCompany(Request $request)
    {
        try {
            DB::beginTransaction();

            $user_details = User::getLoggedInUserDetails();
            $this->checkIfUserIsPermitted($user_details, 'INTEGRATION_COMPANY');
            
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
            
            $newCompany = new \App\Models\Company();
            $newCompany->name = $request->name;
            $newCompany->desc = $request->company_desc;
            $newCompany->location = $request->company_location;
            $newCompany->web_url = $request->web_url;
            $newCompany->youtube_url = $request->youtube_url;
            $newCompany->facebook_url = $request->facebook_url;
            $newCompany->user_id = (int) $user_details['id'];
            $newCompany->save();

            $ImageUploadFileLogo = $request->file('file_logo');
            
            $data = date('Y/m/d');
            $hour = date('H');
            if (!empty($ImageUploadFileLogo)) {                
                $path = 'company/images/' . $data . '/' . $hour . '-' . $newCompany->id;
                $company_image_file_path = imageuploads3($path, $ImageUploadFileLogo);
                $newCompany->image = $company_image_file_path;

                //store in db
                $CompanyImage_logo = new CompanyImage();
                $CompanyImage_logo->company_id = $newCompany->id;
                $CompanyImage_logo->filename = $newCompany->image;
                $CompanyImage_logo->is_main = 0;
                $CompanyImage_logo->type = 'logo';
                $CompanyImage_logo->info = '';
                $CompanyImage_logo->save();
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
                    $path = 'company/images/' . $data . '/' . $hour . '-' . $newCompany->id;
                    $company_image_file_path = imageuploads3($path, $ImageUploadFile);
                    $newCompany->image = $company_image_file_path;

                    //store in db
                    $CompanyImage = new CompanyImage();
                    $CompanyImage->company_id = $newCompany->id;
                    $CompanyImage->filename = $newCompany->image;
                    $CompanyImage->is_main = $file_ismain;
                    $CompanyImage->info = $file_caption;
                    $CompanyImage->save();
                }
            }
            //pdf upload
            for ($i = 0; $i < $request->pdf_files_count; $i++) {
                $file_pdf_caption_ = 'file_pdf_caption_' . $i;
                $PdfUploadFile = $request->file('file_pdf_' . $i);
                $Pdfcaption = $request->$file_pdf_caption_;
                if (!empty($PdfUploadFile)) {
                    $path = 'company/images/' . $data . '/' . $hour . '-' . $newCompany->id;
                    $company_pdf_file_path = imageuploads3($path, $PdfUploadFile);

                    //store in db
                    $companyImage = new CompanyImage();
                    $companyImage->company_id = $newCompany->id;
                    $companyImage->filename = $company_pdf_file_path;
                    $companyImage->type = 'pdf';
                    $companyImage->info = $Pdfcaption;
                    $companyImage->save();
                }
            }

            $request_brands = json_decode($request->brands, true);
            if (isset($request->brands)) {
                foreach ($request_brands as $brand) {                    
                    $CompanyBrand = new CompanyBrand();
                    $CompanyBrand->company_id = $newCompany->id;
                    $CompanyBrand->brand_id = $brand['id'];
                    $CompanyBrand->save();
                }
            }

            $request_projects = json_decode($request->projects, true);
            if (isset($request->projects)) {
                foreach ($request_projects as $projects) {
                    ProjectCompany::where('project_id', $projects['id'])
                            ->where('company_id', $newCompany->id)
                            ->delete();
                    $ProjectCompany = new ProjectCompany();
                    $ProjectCompany->company_id = $newCompany->id;
                    $ProjectCompany->project_id = $projects['id'];
                    $ProjectCompany->save();
                }
            }

            DB::commit();

            return $this->success(['id' => $newCompany->id,
                        'slug' => $newCompany->slug,], 'Your company has been created successfully');
        } catch (Exception $ex) {
            DB::rollback();
            return $this->error($ex->getMessage());
        }
    }

    /**
     * Update company
     * @param Request $request
     * @return type
     */
    public function updateCompany(Request $request)
    {
        try {
            DB::beginTransaction();

            $user_details = User::getLoggedInUserDetails();
            $this->checkIfUserIsPermitted($user_details, 'INTEGRATION_COMPANY');
            
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

            $newCompany = Company::where('id', $request->id)->first();
            $newCompany->name = $request->name;
            $newCompany->desc = $request->company_desc;
            $newCompany->location = $request->company_location;
            $newCompany->web_url = $request->web_url;
            $newCompany->youtube_url = $request->youtube_url;
            $newCompany->facebook_url = $request->facebook_url;
            $newCompany->user_id = (int) $user_details['id'];
            $newCompany->save();

            $ImageUploadFileLogo = $request->file('file_logo');

            $data = date('Y/m/d');
            $hour = date('H');
            if (!empty($ImageUploadFileLogo)) {
                $path = 'company/images/' . $data . '/' . $hour . '-' . $newCompany->id;
                $company_image_file_path = imageuploads3($path, $ImageUploadFileLogo);
                $newCompany->image = $company_image_file_path;

                //store in db
                $CompanyImage_logo = new CompanyImage();
                $CompanyImage_logo->company_id = $newCompany->id;
                $CompanyImage_logo->filename = $newCompany->image;
                $CompanyImage_logo->is_main = 0;
                $CompanyImage_logo->type = 'logo';
                $CompanyImage_logo->info = '';
                $CompanyImage_logo->save();
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
                    $path = 'company/images/' . $data . '/' . $hour . '-' . $newCompany->id;
                    $company_image_file_path = imageuploads3($path, $ImageUploadFile);
                    $newCompany->image = $company_image_file_path;

                    //store in db
                    $CompanyImage = new CompanyImage();
                    $CompanyImage->company_id = $newCompany->id;
                    $CompanyImage->filename = $newCompany->image;
                    $CompanyImage->is_main = $file_ismain;
                    $CompanyImage->info = $file_caption;
                    $CompanyImage->save();
                }
            }
            //pdf upload
            for ($i = 0; $i < $request->pdf_files_count; $i++) {
                $file_pdf_caption_ = 'file_pdf_caption_' . $i;
                $PdfUploadFile = $request->file('file_pdf_' . $i);
                $Pdfcaption = $request->$file_pdf_caption_;
                // dd($Pdfcaption);
                if (!empty($PdfUploadFile)) {
                    $path = 'company/images/' . $data . '/' . $hour . '-' . $newCompany->id;
                    $company_pdf_file_path = imageuploads3($path, $PdfUploadFile);

                    //store in db
                    $companyImage = new CompanyImage();
                    $companyImage->company_id = $newCompany->id;
                    $companyImage->filename = $company_pdf_file_path;
                    $companyImage->type = 'pdf';
                    $companyImage->info = $Pdfcaption;
                    $companyImage->save();
                }
            }

            $request_brands = json_decode($request->brands, true);
            if (isset($request->brands)) {
                CompanyBrand::where('company_id', $request->id)
                        ->delete();
                foreach ($request_brands as $brand) {
                    $CompanyBrand = new CompanyBrand();
                    $CompanyBrand->company_id = $newCompany->id;
                    $CompanyBrand->brand_id = $brand['id'];
                    $CompanyBrand->save();
                }
            }

            $request_projects = json_decode($request->projects, true);
            if (isset($request->projects)) {
                ProjectCompany::where('company_id', $newCompany->id)->delete();
                foreach ($request_projects as $projects) {                    
                    $ProjectCompany = new ProjectCompany();
                    $ProjectCompany->company_id = $newCompany->id;
                    $ProjectCompany->project_id = $projects['id'];
                    $ProjectCompany->save();
                }
            }
            DB::commit();

            return $this->success(['id' => $newCompany->id,
                        'slug' => $newCompany->slug,], 'Your company has been created successfully');
        } catch (Exception $ex) {
            DB::rollback();
            return $this->error($ex->getMessage());
        }
    }

    /**
     * Delete company image 
     * @param Request $request
     * @return type
     */
    public function deleteCompanyImage(Request $request) {
        try {
            $user_details = User::getLoggedInUserDetails();
            $this->checkIfUserIsPermitted($user_details, 'INTEGRATION_COMPANY');
            CompanyImage::where('company_id', $request->company_id)->where('id', $request->id)->delete();

            return $this->success(null, 'Your Company resourse delete successfully');
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }

    /**
     * Delete company
     * @param Request $request
     * @return type
     */
    public function deleteCompany(Request $request) {
        try {
            $user_details = User::getLoggedInUserDetails();
            $this->checkIfUserIsPermitted($user_details, 'INTEGRATION_COMPANY');
            Company::where('id', $request->id)->update(['is_deleted' => 1]);

            return $this->success(null, 'Your company delete successfully');
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }

    public function getAllCompanyData(){
        $user_details   = User::getLoggedInUserDetails();
        $user_id        = $user_details['id'];        

        $getCompanyData = Company::where([['user_id','=',$user_id],['is_deleted','=',0]])->orderBy('name','ASC')->get();
        return $this->success(['companys' => $getCompanyData ?? []], 'List');
    }
}
