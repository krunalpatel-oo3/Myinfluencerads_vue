<?php

namespace App\Http\Controllers\api;

use App\Models\ProjectImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use JWTAuth;
use Carbon\Carbon;
use Config;
use App\CustomFunction\CustomFunction;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Project;
use App\Models\UserProjectVote;
use App\Models\CMSItem;
use App\Models\Category;
use App\Models\Platform;
use App\Models\CustomLine;
use App\Models\ProjectComment;
use App\Models\Company;
use App\Models\ProjectProduct;
use App\Models\ProjectTagTagged;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use App\Models\ProjectCategory;
use App\Models\Product;
use App\Models\ProjectReviews;
use App\Helpers\ResponseTrait;
use App\Helpers\CommonTrait;
use Exception;

class ProjectApiController extends BaseController {

    use ResponseTrait;
    use CommonTrait;

    /**
     * IN USE
     * @param Request $request
     * @param type $project_slug
     * @param type $logged_user_id
     * @return type
     * @throws Exception
     */
    public function detail(Request $request, $project_slug, $logged_user_id = null) {
        try {
            $default_user_avatar_url = config('app.empty_default_user_avatar_url');

            $projectData = Project
                    ::getBySlug($project_slug)
                    // ->getByStatus('A')
                    ->with('creator:id,full_name,profile_photo,location,title,login')
                    ->with(['category', 'reviews'])
                    ->get()
                    ->map(function ($projectDataItem) use ($default_user_avatar_url) {
                        $userProfilePhotoImageProps = ['image_url' => $default_user_avatar_url];
                        if (!empty($projectDataItem->creator->profile_photo)) {
                            $userProfilePhotoImageProps = User::readUserImageProps($projectDataItem->creator['id'], $projectDataItem->creator['profile_photo'] ?? $default_user_avatar_url, true);
                            if (empty($userProfilePhotoImageProps['image_url'])) {
                                $userProfilePhotoImageProps['image_url'] = $default_user_avatar_url;
                            }
                        }
                        $projectDataItem['creatorUserProfilePhotoImageProps'] = $userProfilePhotoImageProps;

                        $projectDataItem->categoryname = "";

                        if (isset($projectDataItem['category'][0]['category_id'])) {
                            $Category = Category::select('title', 'title as text', 'id')->where(['id' => $projectDataItem['category'][0]['category_id']])->first();
                            $projectDataItem->categoryname = $Category['title'];
                            $projectDataItem->categoryselect = $Category;
                        }

                        $products = DB::table('product')
                                ->select('product.name as text', 'product.id', 'product.desc as description', 'qty', 'product_id')
                                ->join('project_product', 'project_product.product_id', '=', 'product.id')
                                ->where(['project_product.project_id' => $projectDataItem->id])
                                ->get()->all();
                        $projectDataItem->productselect = $products;
                        $projectDataItem->creator = [];

                        parse_str(parse_url($projectDataItem->link_youtube, PHP_URL_QUERY), $my_array_of_vars);
                        if (isset($my_array_of_vars['v'])) {
                            $projectDataItem->youtube_id = "https://www.youtube.com/embed/" . $my_array_of_vars['v'];
                        }
                        return $projectDataItem;
                    })
                    ->first();
 
            if ($logged_user_id > 0 && isset($projectData->id)) {
                $userProjectVote = UserProjectVote
                        ::getByUserId($logged_user_id)
                        ->getByProjectId($projectData->id)
                        ->first();
                $projectData->is_already_voted = !empty($userProjectVote);
            }
            if (empty($projectData)) {
                throw new Exception('project slug : ' . $project_slug . ' not found !');
            }

            $projectTags = ProjectTagTagged::GetByProjectId($projectData->id)->orderBy('project_tag_tagged.id', 'desc')->pluck('tag_id')->toArray();

            $project_image = DB::table('project_image')
                            ->where('project_image.project_id', $projectData->id)
                            ->where('project_image.type', 'image')
                            ->orderBy('project_image.id', 'DESC')
                            ->get()
                            ->map(function ($projectImageItem) {
                                // dd($projectImageItem->filename);
                                $projectImageItem->is_main_label = ProjectImage::getIsMainLabel($projectImageItem->is_main);
                                $projectImageItem->created_at_formatted = getCFFormattedDateTime($projectImageItem->created_at);
                                $projectImageItemImgProps = ProjectImage::readProjectImageProps($projectImageItem->project_id, $projectImageItem->filename, true);
                                if (!empty($projectImageItemImgProps)) {
                                    $projectImageItem->projectImagePropsArray = $projectImageItemImgProps;
                                }
                                return $projectImageItem;
                            })->all();
                            
            $project_company = DB::table('project_company')
                            ->where('project_company.project_id', $projectData->id)
                            ->get()
                            ->map(function ($projectCompanyItem) {
                                $projectcompanyData = Company::whereId($projectCompanyItem->company_id)->first();
                                $projectCompanyItem->company_name = $projectcompanyData->name;
                                $projectCompanyItem->company_url = $projectcompanyData->web_url;
                                return $projectCompanyItem;
                            })->all();

            $project_pdf = DB::table('project_image')
                            ->where('project_image.project_id', $projectData->id)
                            ->where('project_image.type', 'pdf')
                            ->orderBy('project_image.id', 'DESC')
                            ->get()
                            ->map(function ($projectPdfItem) {
                                //dd($projectPdfItem);
                                $projectPdfItem->is_main_label = ProjectImage::getIsMainLabel($projectPdfItem->is_main);
                                $projectPdfItem->created_at_formatted = getCFFormattedDateTime($projectPdfItem->created_at);
                                $projectPdfItemImgProps = ProjectImage::readProjectPdfProps($projectPdfItem->project_id, $projectPdfItem->filename, true);
                                //   dd($projectPdfItemImgProps);
                                if (!empty($projectPdfItemImgProps)) {
                                    $projectPdfItem->projectPdfPropsArray = $projectPdfItemImgProps;
                                }
                                return $projectPdfItem;
                            })->all();
            $userProjectVotesCount = UserProjectVote
                    ::getByProjectId($projectData->id)
                    ->count();

            $loggedUserProjectVotesCount = 0;
            if (!empty($logged_user_id) && $logged_user_id != 'null') {
                $loggedUserProjectVotesCount = UserProjectVote
                        ::getByProjectId($projectData->id)
                        ->getByUserId($logged_user_id)
                        ->count();
            }

            $projectData->published_at_formatted = getCFFormattedDate($projectData->published_at);
            $projectcustomLines = CustomLine
                            ::where("project_id", $projectData->id)
                            ->get();

            // foreach ($projectcustomLines as $key => $value) {
            //     $proImage           = ProjectImage::select('filename')->where([['project_id', "=", $value->project_id],['type', "=", "image"]])->first();
            //     $value->filename  = !empty($proImage) ? $proImage['filename'] : "";
            // }
            
            //get related prjects on catgory
            $relatedProjects = [];
            if (isset($projectData->category[0]->category_id)) {
                $relatedProjects = $this->getRelatedProjects($projectData->category[0]->category_id, $logged_user_id, $projectData->id, $project_slug);
            }

            return $this->success([
                        'project' => $projectData,
                        'user_project_votes_count' => $userProjectVotesCount,
                        'loggedUserProjectVotesCount' => $loggedUserProjectVotesCount,
                        'project_image' => $project_image,
                        'project_company' => $project_company,
                        'project_pdf' => $project_pdf,
                        'project_custom_lines' => $projectcustomLines->toArray(),
                        'related_projects' => $relatedProjects,
                        'project_tags' => !empty($projectTags) && count($projectTags) > 0 ? $projectTags : [],
                            // 'is_already_voted' => $userCommunityVotesCount,
                            //  'totalUserProjectViewedCount' => $totalUserCommunityViewedCount,
                            ], "Project detail");
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }

    public function getProjectList(Request $request) {
        try {
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

            return $this->success(['projects' => $list, 'total_page' => $total_page], "List");
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }

    /**
     * IN USE
     * @param Request $request
     * @return type
     */
    public function getProjectListPublic(Request $request) {
        try {
            $page = (int) $request->page ?? 1;
            $limit = (int) $request->limit ?? 5;
            $start = $request->search_text != "" ? 0 : ($limit * ($page - 1));
            
            $user_details = User::getLoggedInUserDetails();
            $logged_user_id = $user_details['id'];

            $query_count = Project::getByStatus('A');           
            $query_count = $this->filterProjects($query_count, $request);
            
            $totalproject = $query_count->count();
            $totalPages = ceil($totalproject / $limit);

            $query = Project::getByStatus('A')
                    ->with(['category', 'reviews'])
                    ->with('ProjectImage', function($query) {
                        $query->where('project_image.type', '=', 'image');
                    });
                    
            $query = $this->filterProjects($query, $request);
            $query = $query->orderBy('project.created_at', 'desc')->offset($start)->limit($limit)->get();
            
            $projects = $this->getProjectdata($query, $logged_user_id);

            return $this->success(['projects' => $projects, 'page' => $page, 'totalPages' => $totalPages], "Public List");
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }

    public function getUserProjectsList(Request $request) {
        try {
            $mode = $request->mode;
            $userProjects = Project :: where('user_id', (int) $request->user_id)->orderBy('name', 'asc')
                    ->get()
                    ->map(function ($userProject) use ($mode) {
                return $mode == 'selection' ? ['id' => $userProject->id, 'name' => $userProject->name] : $userProject;
            });
            return $this->success(['userProjects' => $userProjects,], "User Project List");
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }

    public function getHomeProjects(Request $request) {
        try {
            $page = (int) $request->page ?? 1;
            $data_type = $request->data_type ?? '';
            $recordPerPageConfig = Config::get('constant.record_per_page');
            $limit = 4;
            $start = $limit * ($page - 1);
            $user_details = User::getLoggedInUserDetails();
            $logged_user_id = $user_details['id'];

            $query = Project
                    ::getByStatus('D')
                    ->with('category')
                    ->orderBy('project.created_at', 'desc');
            if ($data_type == 'featured') {
                $query = $query->where('project.featured', 1);
            }
            $projects = $query->offset($start)->limit($limit)
                    ->get()
                    ->map(function ($projectItem) use ($logged_user_id) {
                        $projectItem->creator_full_name = $projectItem->creator->full_name ?? '';
                        $projectItem->created_at_formatted = getCFFormattedDateTime($projectItem->created_at);
                        $projectImageMainItem = ProjectImage
                                ::getByProjectId($projectItem->id)
                                ->getByIsMain(true)
                                ->first();
                        //   dd($projectImageMainItem);
                        $projectItem->is_already_voted = false;
                        if ($logged_user_id > 0) {
                            $userProjectVote = UserProjectVote
                                    ::getByUserId($logged_user_id)
                                    ->getByProjectId($projectItem->id)
                                    ->first();
                            $projectItem->is_already_voted = !empty($userProjectVote);
                        }
                        $empty_img_url = config('app.empty_img_url');
                        if (!empty($projectImageMainItem->project_id)) {
                            $projectImageItemImgProps = ProjectImage::readProjectImageProps($projectImageMainItem->project_id, $projectImageMainItem->filename ?? $empty_img_url, true);
                            $projectImageItemImgProps['info'] = $projectImageMainItem->info;
                        } else {
                            $projectImageItemImgProps['image_url'] = $empty_img_url;
                            $projectImageItemImgProps['info'] = "Default project image";
                        }
                        $projectItem->projectImagePropsArray = $projectImageItemImgProps;

                        return $projectItem;
                    })
                    ->toArray();

            return $this->success(['projects' => $projects, 'page' => $page], "Project List");
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }

    /**
     * IN USE
     * @param Request $request
     * @return type
     */
    public function getFilteredProjects(Request $request) {
        try {
            $page = (int) $request->page ?? 1;
            $data_type = $request->data_type ?? '';
            $recordPerPageConfig = Config::get('constant.record_per_page');
            $limit = $recordPerPageConfig['projects_on_homepage'] ?? 4;
            $start = $limit * ($page - 1);

            $user_details = User::getLoggedInUserDetails();
            $logged_user_id = $user_details['id'];
            
            $query = Project::getByStatus('A')
                    ->with(['category', 'reviews'])
                    ->with('ProjectImage', function($query) {
                        $query->where('project_image.type', '=', 'image');
                    });
                    
            $query = $this->filterProjects($query, $request);
            $query = $query->orderBy('project.created_at', 'desc')->offset($start)->limit($limit)->get();
            
            $projects = $this->getProjectdata($query, $logged_user_id);

            return $this->success(['projects' => $projects, 'page' => $page], "Project List");
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }

    public function voteProject(Request $request) {
        try {
            if (!empty($request->user_id) and ! empty($request->project_id)) {
                $alreadyprojectComments = UserProjectVote
                                ::where('project_id', $request->project_id)
                                ->where('user_id', $request->user_id)
                                ->get()->toArray();
                if (!empty($alreadyprojectComments)) {
                    UserProjectVote::where('project_id', $request->project_id)
                            ->where('user_id', $request->user_id)
                            ->delete();
                    return $this->success(null, "Your vote successfully removed!");
                } else {
                    $userProjectVote = new UserProjectVote();
                    $userProjectVote->user_id = $request->user_id;
                    $userProjectVote->project_id = $request->project_id;
                    $userProjectVote->save();
                    return $this->success(['id' => $userProjectVote->id], "You voted successfully");
                }
            }

            throw new Exception("Invalid vote parameters !");
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }

    // public function voteProject(Request $request)

    public function updateQty(Request $request) {
        try {
            $project_user_id = (int) $request->user_id ?? '';
            if ($project_user_id !== null || $project_user_id !== '' && $request->project_id !== null || $project_id !== '') {
                $product_qty_update = ProjectProduct:: where('project_id', $request->project['project_id'])->where('product_id', $request->project['product_id'])->update(['qty' => $request->project['qty']]);
                if ($product_qty_update) {
                    return $this->success(null, 'Record successfully updated');
                }
            } else {
                throw new Exception('Error Occurred!');
            }
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }

    /**
     * 
     * @param Request $request
     */
    public function doAddStepone(Request $request) {
        try {
            if (!isset($request->name) || $request->name == "") {
                throw new \Exception('Please enter project name');
            }
            if (!isset($request->category) || $request->category == "") {
                throw new \Exception('Please select category');
            }
            if (!isset($request->type) || $request->type == "") {
                throw new \Exception('Please select Project type');
            }
            if (!isset($request->desc) || $request->desc == "") {
                throw new \Exception('Please enter Project description');
            }
            
            $user_details = User::getLoggedInUserDetails();
            $user_id = $user_details['id'];
            
            //check if user is allowed to mark projects as featured
            if (isset($request->is_featured) && $request->is_featured == "true") {                
                $this->checkIfUserIsPermitted($user_details, 'FEATURED_PROJECTS');
            }
            
            //check if user is allowed to create projects
            $this->checkIfUserIsPermitted($user_details, 'PROJECTS');

            $isupdate_request = 0;
            if (isset($request->slug) && $request->slug != "") {
                $isupdate_request = 1;
            }

            $name = CustomFunction::filter_input($request->name);
            $category = CustomFunction::filter_input($request->category);
            $platform_id = CustomFunction::filter_input($request->platform_id);
            $desc = CustomFunction::filter_input($request->desc);

            if ($isupdate_request == 0) {
                // create slug
                $slug = Project::createProjectSlug($name);
                $pr_object = new Project;
            } else {
                $slug = $request->slug;
                $pr_object = Project::where('slug', $slug)->where('user_id', $user_id)->first();
            }

            if (empty($pr_object)) {
                throw new \Exception('Project details not saved, please try again');
            }

            $pr_object->featured = isset($request->is_featured) && $request->is_featured == "true" ? 1 : 0;
            $pr_object->user_id = $user_id;
            $pr_object->name = $name;
            if ($isupdate_request == 0) {
                $pr_object->slug = $slug;
            }
            $pr_object->id = $category;
            $pr_object->platform_id = $platform_id;
            $pr_object->desc = $desc;
            if ($isupdate_request) {
                $pr_object->updated_at = Carbon::now(config('app.timezone'));
            } else {
                $pr_object->approval = $this->checkIfUserIsPermitted($user_details, 'PROJECTS_APPROVAL');
            }

            if ($pr_object->save()) {
                return $this->success(['slug' => $slug], "Project details saved successfully");
            } else {
                throw new \Exception('Project details not saved, please try again');
            }
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }

    /**
     *Edit project
     * @param Request $request
     */
    public function doAddProject(Request $request) {
        try {
            if (!isset($request->name) || $request->name == "") {
                throw new \Exception('Please enter Project name');
            }
            if (!isset($request->category) || $request->category == "") {
                throw new \Exception('Please select category');
            }
            if (!isset($request->type) || $request->type == "") {
                throw new \Exception('Please select Project type');
            }
            if (!isset($request->desc) || $request->desc == "") {
                throw new \Exception('Please enter Project description');
            }
            
            $user_details = User::getLoggedInUserDetails();
            
            //check if user is allowed to mark projects as featured
            if (isset($request->is_featured) && $request->is_featured == "true") {                
                $this->checkIfUserIsPermitted($user_details, 'FEATURED_PROJECTS');
            }
            
            //check if user is allowed to create projects
            $this->checkIfUserIsPermitted($user_details, 'PROJECTS');

            $isupdate_request = 0;
            if (isset($request->slug) && $request->slug != "") {
                $isupdate_request = 1;
            }

            $name = CustomFunction::filter_input($request->name);
            $category = CustomFunction::filter_input($request->category);
            $platform_id = CustomFunction::filter_input($request->platform_id);
            $desc = CustomFunction::filter_input($request->desc);

            $prbudget = CustomFunction::filter_input($request->prbudget);
            $videolink = CustomFunction::filter_input($request->videolink);
            $websitelink = CustomFunction::filter_input($request->websitelink);
            $status = CustomFunction::filter_input($request->status);

            $user_id = $user_details['id'];
            //        $valid_send_picture_image_name = array();
//        $valid_send_diagram_image_name = array();
            if ($isupdate_request == 0) {
                // create slug
                $slug = Project::createProjectSlug($name);
                $pr_object = new Project;
            } else {
                $slug = $request->slug;
                $pr_object = Project::where('slug', $slug)->where('user_id', $user_id)->first();

                if (empty($pr_object)) {
                    throw new \Exception('Project details not updated, please try again');
                }
                //            if ($pr_object->picture != "") {
//                $valid_send_picture_image_name = json_decode($pr_object->picture, true);
//            }
//            if ($pr_object->diagram_img != "") {
//                $valid_send_diagram_image_name = json_decode($pr_object->diagram_img, true);
//            }
            }
            
            $pr_object->user_id = $user_id;
            $pr_object->name = $name;
            if ($isupdate_request == 0) {
                $pr_object->slug = $slug;
            }

            $pr_object->featured = isset($request->is_featured) && $request->is_featured == "true" ? 1 : 0;
            $pr_object->category_id = $category;
            $pr_object->platform_id = $platform_id;
            $pr_object->desc = $desc;
            $pr_object->estimated_budget = $prbudget;

            $pr_object->status = $status;
            if ($isupdate_request) {
                $pr_object->updated_at = Carbon::now(config('app.timezone'));
            } else {
                $pr_object->approval = $this->checkIfUserIsPermitted($user_details, 'PROJECTS_APPROVAL');
            }

            // picture upload

            /*        $valid_send_picture_image_name_str = "";
              if (isset($request->send_picture_image) && $request->send_picture_image != "") {
              $send_picture_image = json_decode($request->send_picture_image, true);
              if ( ! empty($send_picture_image)) {
              foreach ($send_picture_image as $key => $eachimg) {
              $isvalid = CustomFunction::ImageValidation($eachimg, 2);
              if ($isvalid['code'] == 1) {
              $ext               = $isvalid['ext'];
              $random_name       = CustomFunction::random_string(20);
              $uploaded_filename = $random_name . $ext;
              \Log::info('-9 doAddProject $uploaded_filename ::' . print_r($uploaded_filename, true));
              \Log::info('-10 doAddProject file_folder ::' . print_r(file_folder, true));
              $path = file_folder . $uploaded_filename;
              \Log::info('-11 doAddProject $path ::' . print_r($path, true));
              \Image::make(file_get_contents($eachimg))->save($path);
              array_push($valid_send_picture_image_name, $uploaded_filename);
              }
              }
              }
              }
              if ( ! empty($valid_send_picture_image_name)) {
              $valid_send_picture_image_name_str = json_encode($valid_send_picture_image_name);
              }
              $pr_object->picture = $valid_send_picture_image_name_str;
              // diagram upload */

            /*        $valid_send_diagram_image_name_str = "";
              if (isset($request->send_diagram_image) && $request->send_diagram_image != "") {
              $send_diagram_image = json_decode($request->send_diagram_image, true);
              if ( ! empty($send_diagram_image)) {
              foreach ($send_diagram_image as $key => $eachimg) {
              $isvalid = CustomFunction::ImageValidation($eachimg, 2);
              if ($isvalid['code'] == 1) {
              $ext               = $isvalid['ext'];
              $random_name       = CustomFunction::random_string(20);
              $uploaded_filename = $random_name . $ext;
              $path              = file_folder . $uploaded_filename;
              \Image::make(file_get_contents($eachimg))->save($path);
              array_push($valid_send_diagram_image_name, $uploaded_filename);
              }
              }
              }
              } *///        if ( ! empty($valid_send_diagram_image_name)) {         //            $valid_send_diagram_image_name_str = json_encode($valid_send_diagram_image_name);         //        }         //        $pr_object->diagram_img = $valid_send_diagram_image_name_str;                
            if ($pr_object->save()) {

                $id = $pr_object->id;
                // add products
                if (isset($request->products) && $request->products != "") {
                    $products = json_decode($request->products, true);

                    if (!empty($products)) {
                        foreach ($products as $key => $pvalue) {
                            $prname = CustomFunction::filter_input($pvalue['prname']);
                            $prlink = CustomFunction::filter_input($pvalue['prlink']);
                            $prprice = CustomFunction::filter_input($pvalue['prprice']);

                            $newproduct = new ProjectProduct;
                            $newproduct->project_id = $id;
                            $newproduct->name = $prname;
                            $newproduct->link = $prlink;
                            $newproduct->price = $prprice;
                            $newproduct->qty = isset($pvalue['qty']) ? $pvalue['qty'] : 0;
                            $newproduct->status = 1;
                            $newproduct->save();
                        }
                    }
                }

                return $this->success(['slug' => $slug], 'Project details saved successfully');
            } else {
                throw new \Exception('Project details not saved, please try again');
            }
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }
 
    /**
     * IN USE
     * Get related projects on Category
     */
    private function getRelatedProjects($category, $logged_user_id, $project_id, $project_slug)
    {
        $page = 1;
        $request = new Request(['category' => $category, 'project_id' => $project_id]);
        $recordPerPageConfig = Config::get('constant.record_per_page');
        $limit = $recordPerPageConfig['projects_on_homepage'] ?? 4;
        $start = $limit * ($page - 1);

        $query = Project::getByStatus('A')
                    ->with(['category', 'reviews'])
                    ->with('ProjectImage', function($query) {
                        $query->where('project_image.type', '=', 'image');
                    })->where('slug', '!=', $project_slug);
                    
        $query = $this->filterProjects($query, $request);
        $query = $query->orderBy('project.created_at', 'desc')->offset($start)->limit($limit)->get();
        
        return $this->getProjectdata($query, $logged_user_id);
    }

    /**
     *
     * @param Request $request
     */
    public function doUpdateProject(Request $request) {
        try {
            if (!isset($request->slug) || $request->slug == "") {
                throw new Exception('Invalid request, please try again.');
            }
            if (!isset($request->name) || $request->name == "") {
                throw new Exception('Please enter Project name');
            }
            if (!isset($request->category) || $request->category == "") {
                throw new Exception('Please select category');
            }
            if (!isset($request->type) || $request->type == "") {
                throw new Exception('Please select Project type');
            }
            if (!isset($request->desc) || $request->desc == "") {
                throw new Exception('Please enter Project description');
            }

            $user_details = User::getLoggedInUserDetails();
            
            //check if user is allowed to mark projects as featured
            if (isset($request->is_featured) && $request->is_featured == "true") {                
                $this->checkIfUserIsPermitted($user_details, 'FEATURED_PROJECTS');
            }
            
            //check if user is allowed to create projects
            $this->checkIfUserIsPermitted($user_details, 'PROJECTS');

            $name = CustomFunction::filter_input($request->name);
            $category = CustomFunction::filter_input($request->category);
            $platform_id = CustomFunction::filter_input($request->platform_id);
            $desc = CustomFunction::filter_input($request->desc);

            $prbudget = CustomFunction::filter_input($request->prbudget);
            $videolink = CustomFunction::filter_input($request->videolink);
            $websitelink = CustomFunction::filter_input($request->websitelink);
            $status = CustomFunction::filter_input($request->status);

            $user_id = $user_details['id'];
            //        $valid_send_picture_image_name = array();
//        $valid_send_diagram_image_name = array();

            $slug = $request->slug;
            $pr_object = Project::where('slug', $slug)->where('user_id', $user_id)->first();
            if (empty($pr_object)) {
                throw new Exception('Project details not updated, please try again');
            }

            $id = $pr_object->id;
            //        if ($pr_object->picture != "") {
//            $valid_send_picture_image_name = json_decode($pr_object->picture, true);
//        }
//        if ($pr_object->diagram_img != "") {
//            $valid_send_diagram_image_name = json_decode($pr_object->diagram_img, true);
//        }
//
            $pr_object->name = $name;
            $pr_object->id = $category;
            $pr_object->platform_id = $platform_id;
            $pr_object->desc = $desc;
            $pr_object->estimated_budget = $prbudget;
            $pr_object->status = $status;
            $pr_object->updated_at = Carbon::now(config('app.timezone'));
            $pr_object->featured = isset($request->is_featured) && $request->is_featured == "true" ? 1 : 0;

            // remove old images
            /*        if (isset($request->removepicture) && $request->removepicture != "") {
              $removepicture = json_decode($request->removepicture, true);
              if ( ! empty($removepicture)) {
              foreach ($removepicture as $key => $filename) {
              if (file_exists(file_folder . $filename)) {
              $filename_main = file_folder . $filename;
              unlink($filename_main);
              }
              // remove from DB array
              \Log::info('-1 $removepicture  $filename::' . print_r($filename, true));
              \Log::info('-2 $removepicture  $valid_send_picture_image_name::' . print_r($valid_send_picture_image_name,
              true));
              $rmkey_pic = array_search($filename, $valid_send_picture_image_name);
              \Log::info('-2 $removepicture  $rmkey_pic::' . print_r($rmkey_pic, true));
              if (array_key_exists($rmkey_pic, $valid_send_picture_image_name)) {
              unset($valid_send_picture_image_name[$rmkey_pic]);
              }
              }
              $valid_send_picture_image_name = array_values($valid_send_picture_image_name);
              }
              } */

            /*     if (isset($request->removediagram) && $request->removediagram != "") {
              $removediagram = json_decode($request->removediagram, true);
              if ( ! empty($removediagram)) {
              foreach ($removediagram as $key => $filename) {
              if (file_exists(file_folder . $filename)) {
              $filename_main = file_folder . $filename;
              unlink($filename_main);
              }
              // remove from DB array
              $rmkey_dia = array_search($filename, $valid_send_diagram_image_name);
              if (array_key_exists($rmkey_dia, $valid_send_diagram_image_name)) {
              unset($valid_send_diagram_image_name[$rmkey_dia]);
              }
              }
              $valid_send_diagram_image_name = array_values($valid_send_diagram_image_name);
              }
              } */

            // picture upload
            /*        $valid_send_picture_image_name_str = "";
              if (isset($request->send_picture_image) && $request->send_picture_image != "") {
              $send_picture_image = json_decode($request->send_picture_image, true);
              if ( ! empty($send_picture_image)) {
              foreach ($send_picture_image as $key => $eachimg) {
              $isvalid = CustomFunction::ImageValidation($eachimg, 2);
              if ($isvalid['code'] == 1) {
              $ext               = $isvalid['ext'];
              $random_name       = CustomFunction::random_string(20);
              $uploaded_filename = $random_name . $ext;
              $path              = file_folder . $uploaded_filename;
              \Image::make(file_get_contents($eachimg))->save($path);
              array_push($valid_send_picture_image_name, $uploaded_filename);
              }
              }
              }
              }
              if ( ! empty($valid_send_picture_image_name)) {
              $valid_send_picture_image_name_str = json_encode($valid_send_picture_image_name);
              }
              $pr_object->picture = $valid_send_picture_image_name_str; */

            // diagram upload
            $valid_send_diagram_image_name_str = "";
            /*        if (isset($request->send_diagram_image) && $request->send_diagram_image != "") {
              $send_diagram_image = json_decode($request->send_diagram_image, true);
              if ( ! empty($send_diagram_image)) {
              foreach ($send_diagram_image as $key => $eachimg) {
              $isvalid = CustomFunction::ImageValidation($eachimg, 2);
              if ($isvalid['code'] == 1) {
              $ext               = $isvalid['ext'];
              $random_name       = CustomFunction::random_string(20);
              $uploaded_filename = $random_name . $ext;
              $path              = file_folder . $uploaded_filename;
              \Image::make(file_get_contents($eachimg))->save($path);
              array_push($valid_send_diagram_image_name, $uploaded_filename);
              }
              }
              }
              } *///        if ( ! empty($valid_send_diagram_image_name)) {         //            $valid_send_diagram_image_name_str = json_encode($valid_send_diagram_image_name);         //        }         //        $pr_object->diagram_img = $valid_send_diagram_image_name_str;        
            if ($pr_object->save()) {
                // add products
                $products = array();
                if (isset($request->products) && $request->products != "") {
                    $products = json_decode($request->products, true);

                    if (!empty($products)) {
                        foreach ($products as $key => $pvalue) {
                            $prid = $pvalue['prid'];
                            $prname = CustomFunction::filter_input($pvalue['prname']);
                            $prlink = CustomFunction::filter_input($pvalue['prlink']);
                            $prprice = CustomFunction::filter_input($pvalue['prprice']);

                            $prod_object = ProjectProduct::where('id', $prid)->where('id', $id)->first();
                            if (empty($prod_object)) {
                                $prod_object = new ProjectProduct;
                                $prod_object->id = $id;
                            }

                            $prod_object->name = $prname;
                            $prod_object->link = $prlink;
                            $prod_object->price = $prprice;
                            $prod_object->qty = isset($pvalue['qty']) ? $pvalue['qty'] : 0;
                            $prod_object->status = 1;
                            $prod_object->updated_at = Carbon::now(config('app.timezone'));
                            $prod_object->save();
                        }
                    }
                }

                // if empty products then delete all products
                if (empty($products)) {
                    ProjectProduct::where('id', $id)->delete();
                }
                if (isset($request->removeproduct) && $request->removeproduct != "") {
                    $removeproduct = json_decode($request->removeproduct, true);
                    ProjectProduct::whereIn('id', $removeproduct)->delete();
                }

                return $this->success(['data' => 'Project details saved successfully', 'code' => 1, 'slug' => $slug]);
            } else {
                throw new Exception('Project details not saved, please try again');
            }
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }

    /**
     *
     * @param Request $request
     */
    public function doDeleteProject(Request $request) {
        try {
            if (!isset($request->id) || $request->id == "" || !is_numeric($request->id)) {
                throw new Exception('Invalid request, please try again.');
            }
            $user_details = User::getLoggedInUserDetails();
            
            //check if user is allowed to handle projects
            $this->checkIfUserIsPermitted($user_details, 'PROJECTS');
            
            $user_id = $user_details['id'];
            $id = $request->id;

            $prd_obj = Project::where('id', $id)->where('user_id', $user_id)->first();
            if (empty($prd_obj)) {
                throw new Exception('Project not deleted, please try again.');
            }
            
            ProjectProduct::where('project_id', $id)->delete();
            ProjectCategory::where('project_id', $id)->delete();
            \App\Models\ProjectPlatform::where('project_id', $id)->delete();

            if ($prd_obj->delete()) {
                return $this->success(null, 'Project deleted successfully');
            } else {
                throw new Exception('Project not deleted, please try again.');
            }
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }

    public function getTags(Request $request, $project_id) {
        try {
            $project = Project
                    ::getById($project_id)
                    ->getByStatus('A')
                    ->with('user')
                    ->first();
            if (empty($project)) {
                throw new Exception('project id : ' . $project_id . ' not found !');
            }

            $projectTags = ProjectTagTagged
                    ::GetByProjectId($project_id)
                    ->with('tag')
                    ->orderBy('project_tag_tagged.id', 'desc')
                    ->get();


            return $this->success(['projectTags' => $projectTags,], "Ok");
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }

    public function getProduct(Request $request, $project_id) {
        try {
            $project = Project
                    ::getById($project_id)
                    ->getByStatus('A')
                    ->first();

            if (empty($project)) {
                throw new Exception('project id : ' . $project_id . ' not found !');
            }

            $projectProducts = ProjectProduct
                    ::GetByProjectId($project_id)
                    ->with('product')
                    ->orderBy('project_product.id', 'desc')
                    ->get();

            // foreach ($projectProducts as $key => $value) {
            //     $getProductImage = Product_images::where('product_id', $value->product_id)->pluck('image_name');
            //     dump($getProductImage);
            // }
            $projectcustomLines = CustomLine
                            ::where("project_id", $project_id)
                            ->get()->toarray();
            return $this->success([
                        'projectProducts' => $projectProducts,
                        'projectcustomLines' => $projectcustomLines], 'Ok');
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }

    public function getComment(Request $request, $project_id) {
        try {
            $default_user_avatar_url = config('app.empty_default_user_avatar_url');

            $projectComments = ProjectComment
                    ::where('project_id', $project_id)
                    ->orderBy('id', 'desc')
                    ->with('creator:id,full_name,profile_photo,login')
                    ->get()
                    ->map(function ($projectComments) use ($default_user_avatar_url) {
                $userProfilePhotoImageProps = ['image_url' => $default_user_avatar_url];
                if (!empty($projectComments->creator->profile_photo)) {
                    $userProfilePhotoImageProps = User::readUserImageProps($projectComments->creator['id'], $projectComments->creator['profile_photo'] ?? $default_user_avatar_url, true);
                    if (empty($userProfilePhotoImageProps['image_url'])) {
                        $userProfilePhotoImageProps['image_url'] = $default_user_avatar_url;
                    }
                }

                $projectComments['creatorUserProfilePhotoImageProps'] = $userProfilePhotoImageProps;

                return $projectComments;
            });
            
            return $this->success(['projectComments' => $projectComments], 'Ok');
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }

    public function addComment(Request $request) {
        try {
            $newProjectComment = new ProjectComment();
            $newProjectComment->project_id = $request->project_id;
            $newProjectComment->user_id = $request->user_id;
            $newProjectComment->comment = crlf($request->comment);
            $newProjectComment->rating = 0;
            $newProjectComment->save();

            return $this->success(['id' => $newProjectComment->id], 'Your comment was created successfully');
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }
    
    /**
     * IN USE
     * COmmon function to product secondary data
     * @param type $query
     * @param type $logged_user_id
     */
    private function getProjectdata($query, $logged_user_id = 0)
    {
        return $query->map(function ($projectItem) use ($logged_user_id) {
                        $project_votes_count = UserProjectVote::where('project_id', $projectItem->id)->count() ?? 0;
                        $project_comment_count = ProjectComment::where('project_id', $projectItem->id)->count() ?? 0;

                        $projectItem->project_votes_count = $project_votes_count;
                        $projectItem->project_comment_count = $project_comment_count;
                        $default_user_avatar_url = config('app.empty_default_user_avatar_url');
                        $projectItem->creator_full_name = $projectItem->creator->full_name ?? '';
                        $projectItem->created_at_formatted = getCFFormattedDateTime($projectItem->created_at);
                        $userProfilePhotoImageProps = ['image_url' => $default_user_avatar_url];
                        if (!empty($projectItem->creator->profile_photo)) {
                            $userProfilePhotoImageProps = User::readUserImageProps($projectItem->creator->id, $projectItem->creator->profile_photo ?? $default_user_avatar_url, true);
                            if (empty($userProfilePhotoImageProps['image_url'])) {
                                $userProfilePhotoImageProps['image_url'] = $default_user_avatar_url;
                            }
                        }
                        $projectItem['creatorUserProfilePhotoImageProps'] = $userProfilePhotoImageProps;

                        $projectItem->is_already_voted = false;
                        if ($logged_user_id > 0) {
                            $userProjectVote = UserProjectVote
                                    ::getByUserId($logged_user_id)
                                    ->getByProjectId($projectItem->id)
                                    ->first();
                            $projectItem->is_already_voted = !empty($userProjectVote);
                        }
                                                
                        $empty_img_url = config('app.empty_img_url');
                        if (isset($projectItem->ProjectImage) && count($projectItem->ProjectImage->toArray()) > 0) {
                            $projectImageItemImgProps['image_url'] = $projectItem->ProjectImage[0]->filename;
                        } else {
                            $projectImageItemImgProps['image_url'] = $empty_img_url;
                        }
                        $projectItem->projectImagePropsArray = $projectImageItemImgProps;
                        //unset image array once image added to response var
                        unset($projectItem->ProjectImage);
                        
                        $projectItem->categoryname = '';

                        if (isset($projectItem['category'][0]['category_id'])) {
                            $Category = Category::select('title')->where(['id' => $projectItem['category'][0]['category_id']])->first();
                            $projectItem->categoryname = $Category['title'];
                        }
                        
                        //reviews count
                        $projectItem->reviews_count = count($projectItem->reviews);

                        return $projectItem;
                    })
                    ->toArray();
    }
    
    /**
     * IN USE
     * Common function for project filters
     * @param type $query
     * @param type $request
     * @return type
     */
    private function filterProjects($query, $request)
    {
        $data_type = $request->data_type ?? '';
        
        $query = $query->getByName($request->search_text);
        
        if ($data_type == 'featured') {
            $query = $query->where('project.featured', 1);
        }
        
        if($data_type == 'popular'){
            $query = $query->where('project.featured', 0);
        }

        if ($data_type == 'newest') {
            $query = $query->whereRaw('project.created_at >= DATE_SUB(CURDATE(), INTERVAL 180 DAY)');
        }
        if ($request->min_budget !== null || $request->max_budget !== null) {
            $query = $query->whereBetween('estimated_budget', [$request->min_budget, $request->max_budget]);
        }
        
        if (isset($request->category) && !empty($request->category)) {
            $cat = DB::table('project_category')->select(DB::raw("GROUP_CONCAT(project_id) AS projectIds"))
                    ->where('category_id', $request->category)->first();
            
            if(!empty($cat) && $cat->projectIds) {    
                $query = $query->whereIn('project.id', explode(",", $cat->projectIds));
            }
        }
        
        $tag = [];
        if (isset($request->tags) && count($request->tags) > 0) {
            $tag = DB::table('tag')->select(DB::raw("GROUP_CONCAT(id) AS tagIds"))
                    ->whereIn('tag.title', $request->tags)->first();

            if(!empty($tag) && $tag->tagIds) {                
                $query = $query->leftJoin('project_tag_tagged AS PT', 'project.id', '=', 'PT.project_id')
                    ->whereIn('PT.tag_id', explode(",", $tag->tagIds));
            }
        }
        
        return $query;
    }
    
    /**
     * IN USE
     * @param Request $request
     * @return type
     */
    public function addratings(Request $request) {
        try {
            $user_details = User::getLoggedInUserDetails();
            
            if (!isset($request->project_id) || $request->project_id == "") {
                return response()->json(['data' => 'Project id is required', 'code' => 0]);
            }
            
            if (!isset($request->description) || $request->description == "") {
                return response()->json(['data' => 'Description is required', 'code' => 0]);
            }
            
            $productreview = new ProjectReviews();
            $productreview->user_id = $user_details['id'];
            $productreview->project_id = $request->project_id;
            $productreview->description = $request->description;
            $productreview->save();

            return $this->success(null, 'Comment added successfully');
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }

    public function updateReviews(Request $request){
        try {
            $project_id = $request->project_id ?? "";
            $user_id    = $request->user_id ?? "";
            if(!empty($project_id) && !empty($user_id)){
                if(ProjectReviews::where([['project_id', "=" , $project_id], ['user_id', "=" , $user_id], ['is_read', "=" , 0]])->update(['is_read' => 1]))
                    return response()->json(['status' => true, 'data' => 'Comment updated successfully']);

            }
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }
}
