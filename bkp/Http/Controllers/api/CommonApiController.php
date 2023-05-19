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
use App\Models\{Product, ProductReviews};
use App\Models\{Project, ProjectReviews};
use App\Models\Company;
use App\Models\Education;
use App\Models\CustomLine;
use App\Models\ProjectProduct;
use App\Models\ProjectCompany;
use App\Models\ProjectTagTagged;
use App\Models\Skill;
use App\Models\CompanyBrand;
use App\Models\Tag;
use App\Models\UserPortfolio;
use App\Models\UserPortfolioImage;
use App\Models\UserPortfolioSkill;
use App\Models\ProjectPlatform;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Models\Brand;
use App\Models\CompanyImage;
use App\Helpers\ResponseTrait;
use App\Helpers\CommonTrait;
use Exception;
use Mail;

class CommonApiController extends BaseController {

    use ResponseTrait;
    use CommonTrait;

    public function getEducationTest(Request $request) {
        $education = Education::find(7);
        if (empty($education)) {
            return response()->json([
                        'message' => 'Education with id "' . 7 . '" not found !',
                        HTTP_RESPONSE_BAD_REQUEST
            ]);
        }
        $educationImagePropsArray = [];
        $educationImgProps = Education::readEducationImageProps($education->id, $education->image, true);
        if (!empty($educationImgProps)) {
            $educationImagePropsArray = $educationImgProps;
        }

//        \Log::info(varDump($educationImagePropsArray, ' -1 $educationImagePropsArray::'));

        return response()->json([
                    'desc' => $education->desc,
                    'educationImagePropsArray' => $educationImagePropsArray,
                        ], HTTP_RESPONSE_OK);
    }

// public function getBlockCMSItem(Request $request)

    public function getTagsList(Request $request) {
        $mode = $request->mode;
        $category_id = $request->category_id;
        $tags = Tag
                ::getByCategoryId($category_id)
                ->orderBy('tag.title', 'asc')
                ->get()
                ->map(function ($tag) use ($mode) {
                    return $mode == 'only_title' ? ["text" => $tag->title, "description" => $tag->short_desc, "id" => $tag->id] : $tag;
                })
                ->toArray();

        return response()->json(['tags' => $tags], HTTP_RESPONSE_OK);
    }

    public function getProductsList(Request $request) {
        $mode = $request->mode;
        $products = Product
                ::orderBy('product.name', 'asc')
                ->get()
                ->map(function ($product) use ($mode) {
                    return $mode == 'only_name' ? ["text" => $product->name, "id" => $product->id, "description" => $product->short_desc] : $product;
                })
                ->toArray();

        return response()->json(['products' => $products], HTTP_RESPONSE_OK);
    }

    public function getAccesoryProductsList(Request $request) {
        $mode = $request->mode;
        $products = CustomLine::orderBy('name', 'asc')->get()
                    ->map(function ($product) use ($mode) {
                        return $mode == 'only_name' ? ["text" => $product->name, "id" => $product->id, "description" => $product->description] : $product;
                    })->toArray();

        return response()->json(['products' => $products], HTTP_RESPONSE_OK);
    }

    public function getProjectsList(Request $request) {
        $mode = $request->mode;
        $projects = Project
                ::orderBy('project.name', 'asc')
                ->get()
                ->map(function ($project) use ($mode) {
                    return $mode == 'only_name' ? ["text" => $project->name, "id" => $project->id] : $project;
                })
                ->toArray();

        return response()->json(['projects' => $projects], HTTP_RESPONSE_OK);
    }

    public function getBrandsList(Request $request) {
        $mode = $request->mode;
        $brands = Brand
                ::orderBy('brand.name', 'asc')
                ->get()
                ->map(function ($brand) use ($mode) {
                    return $mode == 'only_name' ? ["text" => $brand->name, "id" => $brand->id] : $brand;
                })
                ->toArray();

        return response()->json(['brands' => $brands], HTTP_RESPONSE_OK);
    }

    public function getProjectsCount(Request $request) {
        dd($request->all());
    }

    public function getBlockCMSItem(Request $request) {
        $key = $request->key;
        $cMSItem = CMSItem
                ::getByKey($key)
                ->first();
        if (empty($cMSItem)) {
            return response()->json([
                        'message' => 'CMS Item with key "' . $key . '" not found !',
                        HTTP_RESPONSE_BAD_REQUEST
            ]);
        }

        return response()->json([
                    'cMSItem' => $cMSItem,
                    'key' => $key
                        ], HTTP_RESPONSE_OK);
    }

// public function getBlockCMSItem(Request $request)


    /*    public function getCategoriesList()
      {
      $status = 1;
      $list   = Category::getList($status);
      $code   = 0;
      if (empty( ! $list)) {
      $code = 1;
      }

      return response()->json(['data' => $list, 'code' => $code]);
      } */

    public function getCategoriesList(Request $request) {
        $mode = $request->mode;
        $categories = Category
                ::orderBy('title', 'asc')
                ->get()
                ->map(function ($category) use ($mode) {
            return $mode == 'selection' ? ['id' => $category->id, 'text' => $category->title, "description" => $category->short_desc] : $category;
        });
//            ->toArray(); // If to uncomment it - the same results!
        return response()->json(['categories' => $categories], HTTP_RESPONSE_OK);
    }

    public function getSkillList(Request $request) {
        $mode = $request->mode;
        $skills = Tag
                ::orderBy('title', 'asc')
                ->get()
                ->map(function ($skills) use ($mode) {
                    return $mode == 'selection' ? ['text' => $skills->title, 'id' => $skills->id] : $skills;
                })
                ->toArray();

        return response()->json(['skills' => $skills], HTTP_RESPONSE_OK);
    }

    /*
     * IN USE
     */

    public function publishProject(Request $request) {
        try {
            $is_featured = 0;
            if (isset($request->is_featured) && $request->is_featured == "true") {
                $is_featured = 1;
            }
            $user_details = User::getLoggedInUserDetails();

            //check if user is allowed to mark projects as featured
            if ($is_featured == 1) {
                $this->checkIfUserIsPermitted($user_details, 'FEATURED_PROJECTS');
            }

            //check if user is allowed to create projects
            $this->checkIfUserIsPermitted($user_details, 'PROJECTS');
            
            if(!empty($request->link_url) && !filter_var($request->link_url, FILTER_VALIDATE_URL)) {
                throw new Exception('Link to website is not correct url');
            }
            
            if(!empty($request->link_youtube) && !filter_var($request->link_youtube, FILTER_VALIDATE_URL)) {
                throw new Exception('Youtube link is not correct url');
            }

            $newProject = new Project();
            $newProject->name = $request->title;
            $newProject->short_desc = $request->subtitle;
            $newProject->desc = $request->project_desc;
            $newProject->project_goals = $request->project_goals;
            $newProject->service_upgrade_request = $request->service_upgrade_request;
            $newProject->featured = $is_featured;
            $newProject->estimated_budget = $request->project_budget;
            $newProject->project_phase = $request->pick;
            $newProject->link_url = $request->link_url;
            $newProject->link_youtube = $request->link_youtube;
            // $newProject->category_id = $request->category_id;
            $newProject->status = $this->checkIfUserIsPermitted($user_details, 'PROJECTS_APPROVAL');
            $newProject->user_id = $request->user_id;
            
//            $newProject->type = ($request->fixed_payment === "true") ? 'fixed' : 'hourly';
//            $newProject->hourly_rate = $request->hour_rate;
//            $newProject->weekly_limit = $request->weekly_limit;
            $newProject->save();

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
                    $path = 'profile/images/' . $data . '/' . $hour . '-' . $newProject->id;
                    $image_file_path = imageuploads3($path, $ImageUploadFile);
                    $newProject->image = $image_file_path;

                    //store in db
                    $projectImage = new ProjectImage();
                    $projectImage->project_id = $newProject->id;
                    $projectImage->filename = $newProject->image;
                    $projectImage->is_main = $file_ismain;
                    $projectImage->info = $file_caption;
                    $projectImage->save();
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
                    $path = 'profile/images/' . $data . '/' . $hour . '-' . $newProject->id;
                    $pdf_file_path = imageuploads3($path, $PdfUploadFile);

                    //store in db
                    $projectImage = new ProjectImage();
                    $projectImage->project_id = $newProject->id;
                    $projectImage->filename = $pdf_file_path;
                    $projectImage->type = 'pdf';
                    $projectImage->info = $Pdfcaption;
                    $projectImage->save();
                }
            }

            $request_categories = json_decode($request->category, true);
            // dd($request_categories);
            if (!empty($request->category) and is_array($request_categories)) {
//            foreach ($request_categories as $next_key => $nextCategory) {
//                if (empty($nextCategory['text'])) {
//                    continue;
//                }
                //$foundProduct = Product::getByName($nextProduct['text'])->first();
                // if ( ! empty($foundProduct)) {
                $projectCategory = new \App\Models\ProjectCategory();
                $projectCategory->project_id = $newProject->id;
                $projectCategory->category_id = $request_categories['id'];
                $projectCategory->save();
                //}
                //}
            }

            if(!empty($request->company)){
                $request_companies = json_decode($request->company, true);
                if(!empty($request_companies)){
                    $projectCompany = new ProjectCompany();
                    $projectCompany->project_id = $newProject->id;
                    $projectCompany->company_id = $request_companies['id'];
                    $projectCompany->save();
                }
            }

            $request_custom_line_items = json_decode($request->custom_line_items, true);
            if (!empty($request->custom_line_items) and is_array($request_custom_line_items)) {
                foreach ($request_custom_line_items as $next_key => $request_custom_line_item) {
                    if($request_custom_line_item != null) {
                        $CustomLine = new \App\Models\CustomLine();
                        $CustomLine->project_id = $newProject->id;
                        $CustomLine->name = $request_custom_line_item['name'];
                        $CustomLine->description = $request_custom_line_item['description'];
                        $CustomLine->brand = $request_custom_line_item['brand'];
                        $CustomLine->price = $request_custom_line_item['price'];
                        $CustomLine->link = $request_custom_line_item['link'];
                        $CustomLine->qty = $request_custom_line_item['qty'];
                        $CustomLine->user_id = $request->user_id;
                        $CustomLine->save();
                    }
                }
            }

            $request_products = json_decode($request->products, true);
            if (!empty($request->products) and is_array($request_products)) {
                foreach ($request_products as $next_key => $nextProduct) {
                    if (empty($nextProduct['text'])) {
                        continue;
                    }

                    $foundProduct = Product::getByName($nextProduct['text'])->first();

                    if (!empty($foundProduct)) {
                        $projectProduct = new ProjectProduct();
                        $projectProduct->project_id = $newProject->id;
                        $projectProduct->product_id = $foundProduct->id;
                        $projectProduct->qty = isset($nextProduct['qty']) ? $nextProduct['qty'] : 1;

                        $projectProduct->save();
                    }
                }
            }
            $request_tags = json_decode($request->tags, true);
            if (is_array($request_tags)) {
                foreach ($request_tags as $tag) {
                    $projectTagTagged = new ProjectTagTagged();
                    $projectTagTagged->project_id = $newProject->id;
                    $projectTagTagged->tag_id = $tag['id'];
                    $projectTagTagged->save();
                }
            }

            return $this->success(['id' => $newProject->id, 'slug' => $newProject->slug], 'Your project created successfully');
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }

    /*
     * IN USE
     */

    public function UpdateProject(Request $request) {
        try {
            $user_details = User::getLoggedInUserDetails();

            //check if user is allowed to mark projects as featured
            if (isset($request->is_featured) && $request->is_featured == "true") {
                $this->checkIfUserIsPermitted($user_details, 'FEATURED_PROJECTS');
            }

            //check if user is allowed to create projects
            $this->checkIfUserIsPermitted($user_details, 'PROJECTS');

            
            if($request->link_url != "null" && !empty($request->link_url) && !filter_var($request->link_url, FILTER_VALIDATE_URL)) {
                throw new Exception('Link to website is not correct url');
            }
            
            if($request->link_youtube != "null" && !empty($request->link_youtube) && !filter_var($request->link_youtube, FILTER_VALIDATE_URL)) {
                throw new Exception('Youtube link is not correct url');
            }

            $newProject = Project::where('id', $request->id)->first();
            $newProject->name = $request->title;
            $newProject->short_desc = $request->subtitle;
            $newProject->desc = $request->project_desc;
            $newProject->project_goals = $request->project_goals;
            $newProject->service_upgrade_request = $request->service_upgrade_request;
            $newProject->featured = $request->featured;
            $newProject->estimated_budget = $request->project_budget;
            $newProject->project_phase = $request->project_stage;
            // $newProject->category_id = $request->category_id;
            $newProject->status = 'A';
            $newProject->user_id = $request->user_id;
            $newProject->link_url = $request->link_url;
            $newProject->link_youtube = $request->link_youtube;
            $newProject->featured = isset($request->is_featured) && $request->is_featured == "true" ? 1 : 0;
//            $newProject->type = ($request->fixed_payment === "true") ? 'fixed' : 'hourly';
//            $newProject->hourly_rate = $request->hour_rate;
//            $newProject->weekly_limit = $request->weekly_limit;
            $newProject->save();


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
                    $path = 'profile/images/' . $data . '/' . $hour . '-' . $newProject->id;
                    $image_file_path = imageuploads3($path, $ImageUploadFile);
                    $newProject->image = $image_file_path;

                    //store in db
                    $projectImage = new ProjectImage();
                    $projectImage->project_id = $newProject->id;
                    $projectImage->filename = $newProject->image;
                    $projectImage->is_main = $file_ismain;
                    $projectImage->info = $file_caption;
                    $projectImage->save();
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
                    $path = 'profile/images/' . $data . '/' . $hour . '-' . $newProject->id;
                    $pdf_file_path = imageuploads3($path, $PdfUploadFile);

                    //store in db
                    $projectImage = new ProjectImage();
                    $projectImage->project_id = $newProject->id;
                    $projectImage->filename = $pdf_file_path;
                    $projectImage->type = 'pdf';
                    $projectImage->info = $Pdfcaption;
                    $projectImage->save();
                }
            }

            $request_categories = json_decode($request->category, true);
            if (!empty($request->category) and is_array($request_categories)) {
                $projectCategory = new \App\Models\ProjectCategory();
                $projectCategory->project_id = $newProject->id;
                $projectCategory->category_id = $request_categories['id'];
                $projectCategory->save();
            }

            $request_custom_line_items = json_decode($request->custom_line_items, true);
            if (!empty($request->custom_line_items) and is_array($request_custom_line_items)) {
                CustomLine::where('project_id', $request->id)
                        ->delete();
                foreach ($request_custom_line_items as $next_key => $request_custom_line_item) {
                    if($request_custom_line_item != null) {
                        $CustomLine = new \App\Models\CustomLine();
                        $CustomLine->project_id = $newProject->id;
                        $CustomLine->name = $request_custom_line_item['name'];
                        $CustomLine->description = $request_custom_line_item['description'];
                        $CustomLine->brand = $request_custom_line_item['brand'];
                        $CustomLine->price = $request_custom_line_item['price'];
                        $CustomLine->link = $request_custom_line_item['link'];
                        $CustomLine->qty = $request_custom_line_item['qty'];
                        $CustomLine->user_id = $request->user_id;
                        $CustomLine->save();
                    }
                }
            }

            $request_products = json_decode($request->products, true);
            if (!empty($request->products) and is_array($request_products)) {
                ProjectProduct::where('project_id', $request->id)
                        ->delete();
                foreach ($request_products as $next_key => $nextProduct) {
                    if (empty($nextProduct['text'])) {
                        continue;
                    }

                    $foundProduct = Product::getByName($nextProduct['text'])->first();

                    if (!empty($foundProduct)) {
                        $projectProduct = new ProjectProduct();
                        $projectProduct->project_id = $newProject->id;
                        $projectProduct->product_id = $foundProduct->id;
                        $projectProduct->qty = isset($nextProduct['qty']) ? $nextProduct['qty'] : 1;
                        $projectProduct->save();
                    }
                }
            }
            $request_tags = json_decode($request->tags, true);
            if (!empty($request_tags) and is_array($request_tags)) {
                ProjectTagTagged::where('project_id', $request->id)
                        ->delete();
                foreach ($request_tags as $tag) {
                    $projectTagTagged = new ProjectTagTagged();
                    $projectTagTagged->project_id = $newProject->id;
                    $projectTagTagged->tag_id = $tag['id'];
                    $projectTagTagged->save();
                }
            }
            return $this->success(['id' => $newProject->id, 'slug' => $newProject->slug],
                    'Your project update successfully');
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }

    public function DeleteProjectImage(Request $request) {


        ProjectImage::where('project_id', $request->project_id)->where('id', $request->id)
                ->delete();

        return response()->json([
                    'message' => 'Your project image delete successfully',
                    'slug' => "",
                        ], HTTP_RESPONSE_OK
        );
    }

    public function DeletePortfolioImage(Request $request) {


        UserPortfolioImage::where('id', $request->id)
                ->delete();

        return response()->json([
                    'message' => 'Your portfolio image delete successfully',
                    'slug' => "",
                        ], HTTP_RESPONSE_OK
        );
    }

    public function DeletePortfolio(Request $request) {

        UserPortfolioSkill::where('portfolio_id', $request->id)
                ->delete();
        UserPortfolioImage::where('portfolio_id', $request->id)
                ->delete();
        UserPortfolio::where('id', $request->id)
                ->delete();

        return response()->json([
                    'message' => 'Your portfolio delete successfully',
                    'slug' => "",
                        ], HTTP_RESPONSE_OK
        );
    }

    public function publishCompany(Request $request) {

        $user_type = User::select('user_type')->where('id', $request->user_id)->first();

        $newCompany = new \App\Models\Company();
        $newCompany->name = $request->name;
        // $newProject->short_desc = $request->subtitle;
        $newCompany->desc = $request->company_desc;
        $newCompany->location = $request->company_location;
        $newCompany->web_url = $request->web_url;
        $newCompany->youtube_page = $request->youtube_page;
        $newCompany->youtube_url = $request->youtube_url;
        $newCompany->facebook_url = $request->facebook_url;
        // $newProject->category_id = $request->category_id;

        $newCompany->user_id = (int) $request->user_id;
        $newCompany->save();


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
                $path = 'company/images/' . $data . '/' . $hour . '-' . $newCompany->id;
                $image_file_path = imageuploads3($path, $ImageUploadFile);
                $newCompany->image = $image_file_path;

                //store in db
                $CompanyImage = new CompanyImage();
                $CompanyImage->project_id = $newCompany->id;
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

                $data = date('Y/m/d');
                $hour = date('H');
                $path = 'company/images/' . $data . '/' . $hour . '-' . $newCompany->id;
                $image_file_path = imageuploads3($path, $PdfUploadFile);

                //store in db
                $companyImage = new CompanyImage();
                $companyImage->company_id = $newCompany->id;
                $companyImage->filename = $image_file_path;
                $companyImage->type = 'pdf';
                $companyImage->info = $Pdfcaption;
                $companyImage->save();
            }
        }

//        $request_categories = json_decode($request->category, true);
//        // dd($request_categories);
//        if (!empty($request->category) and is_array($request_categories)) {
////            foreach ($request_categories as $next_key => $nextCategory) {
////                if (empty($nextCategory['text'])) {
////                    continue;
////                }
//            //$foundProduct = Product::getByName($nextProduct['text'])->first();
//            // if ( ! empty($foundProduct)) {
//            $projectCategory = new \App\Models\ProjectCategory();
//            $projectCategory->project_id = $newProject->id;
//            $projectCategory->category_id = $request_categories['id'];
//            $projectCategory->save();
//            //}
//            //}
//        }

        $request_platforms = json_decode($request->platform, true);
        if (!empty($request->platform) and is_array($request_platforms)) {
            foreach ($request_platforms as $next_key => $nextPlatforms) {
                if (empty($nextPlatforms['text'])) {
                    continue;
                }

                // $foundProduct = Product::getByName($nextProduct['text'])->first();
                //  if ( ! empty($foundProduct)) {
                $projectProduct = new \App\Models\ProjectPlatform();
                $projectProduct->project_id = $newProject->id;
                $projectProduct->platform_id = $nextPlatforms['id'];
                $projectProduct->save();
                // }
            }
        }

        $request_products = json_decode($request->products, true);
        if (!empty($request->products) and is_array($request_products)) {
            foreach ($request_products as $next_key => $nextProduct) {
                if (empty($nextProduct['text'])) {
                    continue;
                }

                $foundProduct = Product::getByName($nextProduct['text'])->first();

                if (!empty($foundProduct)) {
                    $projectProduct = new ProjectCompany();
                    $projectProduct->project_id = $newCompany->id;
                    $projectProduct->product_id = $foundProduct->id;
                    $projectProduct->save();
                }
            }
        }
        $request_brands = json_decode($request->brands, true);
        foreach ($request_brands as $brand) {
            $CompanyBrand = new CompanyBrand();
            $CompanyBrand->company_id = $newCompany->id;
            $CompanyBrand->brand_id = $brand['id'];
            $CompanyBrand->save();
        }

        if ($user_type['user_type'] != 'pro') {
            return response()->json([
                        'message' => 'Your request has been sent for approval from admin',
                        'id' => $newCompany->id,
                        'slug' => $newCompany->slug,
                        'status' => 'N'
                            ], HTTP_RESPONSE_OK
            );
        }
        return response()->json([
                    'message' => 'Your project created successfully',
                    'id' => $newCompany->id,
                    'slug' => $newCompany->slug,
                        ], HTTP_RESPONSE_OK
        );


//        }
        // return response()->json([
        //             'message' => 'Invalid vote parameters !',
        //                 ], HTTP_RESPONSE_BAD_REQUEST
        // );
    }
    
    public function getSearcFilterData(Request $request) {
        $serch              = $request->search_text;
        $serchProductData   = Product::select('id','name','slug')->getByName($serch)->get();
        $serchProjectData   = Project::select('id','name','slug')->getByName($serch)->get();
        return response()->json(['projects' => $serchProjectData->toArray(), 'products' => $serchProductData->toArray()], HTTP_RESPONSE_OK);
    }

    public function sendMailUser(Request $request) {
        $title          = $request->title ?? '';
        $subject        = $request->subject ?? '';
        $description    = $request->description ?? '';
        $username       = $request->username ?? '';
        $useremail      = $request->useremail ?? '';

        try {
            $data = array(
                'name'          => "StreamGeeks",
                'title'         => $title,
                'description'   => $description
            );
            Mail::send('emails.contactmail', $data, function($message) use($useremail, $subject, $username) {
                $message->to($useremail, 'Test Mail')->subject($subject);
                $message->from('tretanz.demo@gmail.com',$username);
            });

            return response()->json([
                    'status'    => true,
                    'message'   => 'Contacted successfully!'], HTTP_RESPONSE_OK);
        } catch (Exception $ex) {
            return response()->json([
                'status'    => false,
                'message'   => $this->error($ex->getMessage())
            ]);
        }
    }

    public function getNotificationData(Request $request) {
        $user_details           = User::getLoggedInUserDetails();
        // $getUserProjects        = Project::with('reviews')->where('user_id',$user_details['id'])->get();
        $getUserProjects        = Project::select('id')->where('user_id',$user_details['id'])->get();
        $getUserPrducts         = Product::select('id')->where('user_id',$user_details['id'])->get();
        $notificationProjArr    = [];
        $notificationProdArr    = [];
        $totalNotiCount         = 0;

        // Manage for projects
        foreach ($getUserProjects as $key => $value) {
            $getUserProjectReviews  = ProjectReviews::with('project','user')->where([['project_id', "=" ,$value['id']], ['user_id', "!=" ,$user_details['id']], ['is_read', "=" , 0]])->get();
            foreach ($getUserProjectReviews as $reviewKey => $reviewValue) {
                $reviewValue['before_day'] = Carbon::createFromFormat('Y-m-d H:i:s', $reviewValue['created_at'])->diffForHumans();
            }
            if(!empty($getUserProjectReviews) && count($getUserProjectReviews) > 0){
                $notificationProjArr[] = $getUserProjectReviews;
            }
        }

        // Manage for products
        foreach ($getUserPrducts as $key => $prodValue) {
            $getUserProductReviews  = ProductReviews::with('product','user')->where([['product_id', "=" ,$prodValue['id']], ['user_id', "!=" ,$user_details['id']], ['is_read', "=" , 0]])->get();
            foreach ($getUserProductReviews as $reviewKey => $prodReviewValue) {
                $prodReviewValue['before_day'] = Carbon::createFromFormat('Y-m-d H:i:s', $prodReviewValue['created_at'])->diffForHumans();
            }
            if(!empty($getUserProductReviews) && count($getUserProductReviews) > 0){
                $notificationProdArr[] = $getUserProductReviews;
            }
        }

        $totalNotiCount = count($notificationProjArr) + count($notificationProdArr);

        return response()->json([
            'status' => true, 
            'getUserProjectReviews' => $notificationProjArr,
            'getUserProductReviews' => $notificationProdArr,
            'totalNotiCount'        => $totalNotiCount,
        ], HTTP_RESPONSE_OK);
    }
}
