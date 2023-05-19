<?php

namespace App\Http\Controllers\api;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Mail;
use Config;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\GeneralSetting;
use App\Models\UserCategorySkill;
use App\Models\UserCategory;
use App\Models\UserPortfolio;
use App\Models\UserPortfolioImage;
use App\Models\ProjectImage;
use App\Models\UserPortfolioSkill;
use App\Models\UserLanguage;
use App\Models\Community;
use App\Models\CommunityAnswer;
use App\Models\CommunityTagTagged;
use App\Models\UserCommunityVote;
use App\Models\UserCommunityViewed;
use App\Models\Project;
use App\Models\Product;
use App\Models\Category;
use Validator;
use Hash;
use JWTAuth;
use App\CustomFunction\CustomFunction;
use App\CustomFunction\LinkedIn;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Mail\SendgridMail;
use App\Helpers\ResponseTrait;
use App\Helpers\CommonTrait;

class ProfileController extends BaseController {

    use ResponseTrait;
    use CommonTrait;
    
    public function index(Request $request) {
        $loggedUser = auth()->user();
        $default_user_avatar_url = config('app.empty_default_user_avatar_url');

        if (!empty($loggedUser->profile_photo)) {
            $loggedUserProfilePhotoImageProps = User::readUserImageProps($loggedUser->id, $loggedUser->profile_photo ?? $default_user_avatar_url, true);
            if (empty($loggedUserProfilePhotoImageProps)) {
                $loggedUserProfilePhotoImageProps['image_url'] = $default_user_avatar_url;
            }
        } else {
            $loggedUserProfilePhotoImageProps['image_url'] = $default_user_avatar_url;
        }
        return response()->json([
                    'loggedUser' => $loggedUser,
                    'loggedUserProfilePhotoImageProps' => $loggedUserProfilePhotoImageProps,
                        ], HTTP_RESPONSE_OK);
    }

    public function UpdateUserType(Request $request) {
        $loggedUser = auth()->user();
        $update_user = User::where('id', $loggedUser->id)->first();
        $update_user->user_type = $request->user_type;
        $update_user->updated_at = Carbon::now(config('app.timezone'));
        if ($update_user->save()) {
            return response()->json([
                        'user' => $loggedUser,
                            ], HTTP_RESPONSE_OK);
        } else {
            return response()->json([
                        'data' => 'Profile not updated, please try again',
                        'code' => 0]
            );
        }
    }

    public function doUpdateUserProfileImage(Request $request) {
        $ud = auth()->user();
        if (!empty($ud)) {
            $uid = $ud->id;
        } else {
            return response()->json(['data' => 'Profile not updated, please try again', 'code' => 0]);
        }
        $ext = ".jpg";
        $update_user = User::where('id', $uid)->first();
        $update_user->updated_at = Carbon::now(config('app.timezone'));

        $uploaded_filename = $update_user->profile_photo;
        $image_file_path = $request->file('profilephoto');
        // dd($request->hasfile('profilephoto'));
        if ($request->file('profilephoto')) {
//            $oldfile = $update_user->profile_photo;
//            $random_name = CustomFunction::random_string(20);
//            $uploaded_filename = $random_name . $ext;
//            $path = file_folder . $uploaded_filename;
//            $path_image_file = $request->file('profilephoto')->getClientOriginalName();//$image_file_path->getPathName();
//            dd(File::get($path_image_file));
//            $dest_image = 'public/' . User::getProfileImageDir($uid) . $uploaded_filename;
//            dd(Storage::disk('local')->put($dest_image, File::get($path_image_file)));
//            Storage::disk('local')->put($dest_image, File::get($path_image_file));
//            $update_user->profile_photo = $uploaded_filename;

            // $random_name = CustomFunction::random_string(20);
            // $uploaded_filename = $random_name . $ext;
            // $path = file_folder . $uploaded_filename;
            // $path_image_file = $image_file_path->getPathName();
            // $dest_image = 'public/' . User::getProfileImageDir($uid) . $uploaded_filename;
            // Storage::disk('local')->put($dest_image, File::get($path_image_file));
            // $update_user->profile_photo = $uploaded_filename;
			
			$data = date('Y/m/d');
			$hour = date('H');
			$path = 'profile/images/'.$data.'/'.$hour.'-'.$uid;
			$image_file_path = imageuploads3($path,$request->file('profilephoto'));
			$update_user->profile_photo     = $image_file_path;
        }

        if ($update_user->save()) {
            return response()->json([
                        'data' => 'Profile updated successfully',
                        'code' => 1,
                        'photo' => User::readUserImageProps($uid, $uploaded_filename)
            ]);
        } else {
            return response()->json(['data' => 'Profile not updated, please try again', 'code' => 0]);
        }
    }

    public function doUpdateUserCoverImage(Request $request) {
        $ud = auth()->user();
        if (!empty($ud)) {
            $uid = $ud->id;
        } else {
            return response()->json(['data' => 'Profile not updated, please try again', 'code' => 0]);
        }
        $ext = ".jpg";
        $update_user = User::where('id', $uid)->first();
        $update_user->updated_at = Carbon::now(config('app.timezone'));

        $uploaded_filename = $update_user->coverphoto;
        $image_file_path = $request->file('coverphoto');
        if ($request->file('coverphoto') != "") {
            // delete old file
            $oldfile = $update_user->cover_image;
//            if ($oldfile != '') {
//                if (file_exists(file_folder . $oldfile)) {
//                    $filename = file_folder . $oldfile;
//                    unlink($filename);
//                }
//            }
//dd($image_file_path->getPathName());
            // $random_name = CustomFunction::random_string(20);
            // $uploaded_filename = $random_name . $ext;
            // $path = file_folder . $uploaded_filename;
            // $path_image_file = $image_file_path->getPathName();
            // $dest_image = 'public/' . User::getCoverImageDir($uid) . $uploaded_filename;
            // Storage::disk('local')->put($dest_image, File::get($path_image_file));
            // $update_user->cover_image = $uploaded_filename;
			
			$data = date('Y/m/d');
			$hour = date('H');
			$path = 'profile/images/'.$data.'/'.$hour.'-'.$uid;
			$image_file_path = imageuploads3($path,$request->file('coverphoto'));
			$update_user->cover_image     = $image_file_path;
        }

        if ($update_user->save()) {
            return response()->json([
                        'data' => 'Profile updated successfully',
                        'code' => 1,
                        'photo' => User::readUserCoverProps($uid, $uploaded_filename)
            ]);
        } else {
            return response()->json(['data' => 'Profile not updated, please try again', 'code' => 0]);
        }
    }

    /**
     *
     * @param Request $request
     *
     * @return type
     */
    public function doUpdateUserProfileSetting(Request $request) {

        $ud = auth()->user();
        if (!empty($ud)) {
            $uid = $ud->id;
        } else {
            return response()->json(['data' => 'Profile not updated, please try again', 'code' => 0]);
        }

        $update_user = User::where('id', $uid)->first();
        if (isset($request->full_name) && !empty($request->full_name)) {
            $update_user->full_name = $request->full_name;
        }
        if (isset($request->email) && !empty($request->email)) {
            $userEmailExist = User::where('email', $request->email)->exists();
            if($update_user['email'] != $request->email && $userEmailExist)
                return response()->json(['data' => 'Email is already exists!Please try again with new one.', 'code' => 0]);
            else
                $update_user->email = $request->email;
        }

        if (isset($request->address) && !empty($request->address)) {
            $update_user->address = $request->address;
        }
        if (isset($request->timezone) && !empty($request->timezone)) {
            $update_user->timezone = $request->timezone;
        }
        if (isset($request->phone) && !empty($request->phone)) {
            $update_user->phone = $request->phone;
        }
        if (isset($request->country) && !empty($request->country)) {
            $update_user->country = $request->country;
        }
        if (isset($request->city) && !empty($request->city)) {
            $update_user->city = $request->city;
        }
        if (isset($request->postal_code) && !empty($request->postal_code)) {
            $update_user->postal_code = $request->postal_code;
        }
        if (isset($request->city) && !empty($request->country)) {
            $update_user->location = $request->city . ',' . $request->country;
        }
        if (isset($request->password) && !empty($request->password)) {
            $old_password = CustomFunction::filter_input($request->old_password);
            $new_password = CustomFunction::filter_input($request->password);
            $password_old_hash = Hash::make($old_password);

            $token = JWTAuth::attempt([
                        'email' => $update_user->email,
                        'password' => $request->old_password,
                        'urole' => user_role
                            ]
            );
            if ($token) {
                $update_user->password = Hash::make($new_password);
            } else {
                return response()->json(['data' => 'Please enter valid current password.', 'code' => 0]);
            }
        }

        $update_user->updated_at = Carbon::now(config('app.timezone'));

        if ($update_user->save()) {
            return response()->json([
                        'data' => 'Profile updated successfully',
                        'code' => 1,
                        'update_user' => $update_user
            ]);
        } else {
            return response()->json(['data' => 'Profile not updated, please try again', 'code' => 0]);
        }
    }

    public function doUpdateUserProfile(Request $request) {
        if (!isset($request->name) || $request->name == "") {
            return response()->json(['data' => 'Please enter Name', 'code' => 0]);
        }

        $ext = ".jpg";
        if (isset($request->profilephoto) && $request->profilephoto != "") {

            $valid_files = array("image/bmp", "image/jpeg", "image/png");

            $pos = strpos($request->profilephoto, ';');
            if ($pos) {
                $mimetype = explode(':', substr($request->profilephoto, 0, $pos))[1];
                if (!in_array($mimetype, $valid_files)) {
                    return response()->json(['data' => 'Image must be only jpg,png or bmp', 'code' => 0]);
                }

                if ($mimetype == "image/bmp") {
                    $ext = '.jpg';
                }
                if ($mimetype == "image/jpeg") {
                    $ext = '.jpg';
                }
                if ($mimetype == "image/png") {
                    $ext = '.png';
                }

                $strlen = strlen($request->profilephoto);
                $size = ($strlen * (3 / 4));
                $size = ($size / 1024) / 1024;
                $size = round($size, 2); // size in mb

                if ($size > 2) {
                    return response()->json(['data' => 'Max. Image size must be 2mb', 'code' => 0]);
                }
            } else {
                return response()->json(['data' => 'Image must be only jpg,png or bmp', 'code' => 0]);
            }
        }

        $ud = auth()->user();
        if (!empty($ud)) {
            $uid = $ud->id;
        } else {
            return response()->json(['data' => 'Profile not updated, please try again', 'code' => 0]);
        }

        $name = CustomFunction::filter_input($request->name);
        $location = CustomFunction::filter_input($request->location);
        $service = CustomFunction::filter_input($request->service);
        $tagline = CustomFunction::filter_input($request->tagline);

        $fblink = $instalink = $twlink = "";
        if (isset($request->fblink) && $request->fblink != "") {
            $fblink = $request->fblink;
        }
        if (isset($request->instalink) && $request->instalink != "") {
            $instalink = $request->instalink;
        }
        if (isset($request->twlink) && $request->twlink != "") {
            $twlink = $request->twlink;
        }

        $social_link = array();
        $social_link['fb'] = CustomFunction::filter_input($fblink);
        $social_link['insta'] = CustomFunction::filter_input($instalink);
        $social_link['tw'] = CustomFunction::filter_input($twlink);

        $social_link_str = json_encode($social_link);

        $update_user = User::where('id', $uid)->first();
        $update_user->full_name = stripslashes($name);
        $update_user->location = stripslashes($location);
        $update_user->service = $service;
        $update_user->tag_line = $tagline;
        $update_user->social_link = $social_link_str;
        $update_user->updated_at = Carbon::now(config('app.timezone'));

        $uploaded_filename = $update_user->profile_photo;
        if ($request->file('profilephoto') != "") {
            // delete old file
            // $oldfile = $update_user->profile_photo;
            // if ($oldfile != '') {
                // if (file_exists(file_folder . $oldfile)) {
                    // $filename = file_folder . $oldfile;
                    // unlink($filename);
                // }
            // }

            // $random_name = CustomFunction::random_string(20);
            // $uploaded_filename = $random_name . $ext;
            // $path = file_folder . $uploaded_filename;
            // \Image::make(file_get_contents($request->profilephoto))->save($path);
            // $update_user->profile_photo = $uploaded_filename;
			
			$data = date('Y/m/d');
			$hour = date('H');
			$path = 'profile/images/'.$data.'/'.$hour.'-'.$uid;
			$image_file_path = imageuploads3($path,$request->file('profilephoto'));
			$update_user->profile_photo     = $image_file_path;
        }

        if ($update_user->save()) {
            return response()->json([
                        'data' => 'Profile updated successfully',
                        'code' => 1,
                        'photo' => $uploaded_filename
            ]);
        } else {
            return response()->json(['data' => 'Profile not updated, please try again', 'code' => 0]);
        }
    }

    public function doUpdateUserProfileAbout(Request $request) {
        if (!isset($request->title) || $request->title == "") {
            return response()->json(['data' => 'Please enter title', 'code' => 0]);
        }


        $ud = auth()->user();
        if (!empty($ud)) {
            $uid = $ud->id;
        } else {
            return response()->json(['data' => 'Profile not updated, please try again', 'code' => 0]);
        }

        $title = CustomFunction::filter_input($request->title);
        $description = CustomFunction::filter_input($request->description);
        $hourly_rate = CustomFunction::filter_input($request->hourly_rate);

        $update_user = User::where('id', $uid)->first();
        $update_user->title = $title;
        $update_user->description = stripslashes($description);
        $update_user->hourly_rate = $hourly_rate;
        $update_user->updated_at = Carbon::now(config('app.timezone'));

        if ($update_user->save()) {
            return response()->json([
                        'data' => 'Profile updated successfully',
                        'code' => 1,
                        'user' => $update_user
            ]);
        } else {
            return response()->json(['data' => 'Profile not updated, please try again', 'code' => 0]);
        }
    }

    public function doUpdateUserEducation(Request $request) {
        if (!isset($request->school) || $request->school == "") {
            return response()->json(['data' => 'Please enter school', 'code' => 0]);
        }


        $ud = auth()->user();
        if (!empty($ud)) {
            $uid = $ud->id;
        } else {
            return response()->json(['data' => 'Profile not updated, please try again', 'code' => 0]);
        }

        $school = CustomFunction::filter_input($request->school);
        $degree = CustomFunction::filter_input($request->degree);
        $area_study = CustomFunction::filter_input($request->area_study);
        $school_start_date = $request->school_start_date ? CustomFunction::filter_input($request->school_start_date) : null;
        $school_end_date = $request->school_end_date ? CustomFunction::filter_input($request->school_end_date) : null;

        $update_user = User::where('id', $uid)->first();
        $update_user->school = stripslashes($school);
        $update_user->degree = stripslashes($degree);
        $update_user->area_study = stripslashes($area_study);
        $update_user->school_start_date = $school_start_date;
        $update_user->school_end_date = $school_end_date;
        $update_user->updated_at = Carbon::now(config('app.timezone'));

        if ($update_user->save()) {
            return response()->json([
                        'data' => 'Profile education updated successfully',
                        'code' => 1,
                        'user' => $update_user
            ]);
        } else {
            return response()->json(['data' => 'Profile education not updated, please try again', 'code' => 0]);
        }
    }

    public function doAddUserProfilePortfolio(Request $request) {
	
        $ud = auth()->user();
        if (!empty($ud)) {
            $uid = $ud->id;
        } else {
            return response()->json(['data' => 'Profile not updated, please try again', 'code' => 0]);
        }

        $update_Portfolio_user = new UserPortfolio();

        $update_Portfolio_user->title = stripslashes($request->title);
        $update_Portfolio_user->description = stripslashes($request->description);
        $update_Portfolio_user->start_date = $request->start_date;
        $update_Portfolio_user->end_date = $request->end_date;
        //  $update_Portfolio_user->gallery_image = $request->gallery_image;
        $update_Portfolio_user->user_id = $uid;
        $update_Portfolio_user->created_at = Carbon::now(config('app.timezone'));
        $update_Portfolio_user->save();

        $ext = ".jpg";
        //dd($request->file('gallery_image'));
        foreach ($request->file('gallery_image') as $key => $gallery_image) {
            $image_file_path = $gallery_image;
            //$oldfile = $update_user->cover_image;
            // $random_name = CustomFunction::random_string(20);
            // $uploaded_filename = $random_name . $ext;
            // $path = file_folder . $uploaded_filename;
            // $path_image_file = $image_file_path->getPathName();
            // $dest_image = 'public/' . UserPortfolio::getPortfolioImageDir($update_Portfolio_user['id']) . $uploaded_filename;
            // Storage::disk('local')->put($dest_image, File::get($path_image_file));
			
			$data = date('Y/m/d');
			$hour = date('H');
			$path = 'profile/images/'.$data.'/'.$hour.'-'.$uid;
			$uploaded_filename = imageuploads3($path,$gallery_image);
			
            $update_user_portfolio_image = new UserPortfolioImage();
            $update_user_portfolio_image->portfolio_id = $update_Portfolio_user['id'];
            $update_user_portfolio_image->filename = $uploaded_filename;
            $update_user_portfolio_image->type = 'image';
            $update_user_portfolio_image->created_at = Carbon::now(config('app.timezone'));
            $update_user_portfolio_image->save();
        }


        if (isset($request->skill)) {

            $skills = json_decode($request->skill);
            foreach ($skills as $skill) {
                $update_user = new UserPortfolioSkill();
                $update_user->portfolio_id = $update_Portfolio_user['id'];
                $update_user->skill_id = $skill->id;
                $update_user->user_id = $uid;
                $update_user->created_at = Carbon::now(config('app.timezone'));
                $update_user->save();
            }
        }
        if ($update_Portfolio_user) {
            return response()->json([
                        'data' => 'Profile skill updated successfully',
                        'code' => 1,
                        'user' => $update_Portfolio_user
            ]);
        } else {
            return response()->json(['data' => 'Profile skill not updated, please try again', 'code' => 0]);
        }
    }

    public function doUpdateUserProfilePortfolio(Request $request) {

        $ud = auth()->user();
        if (!empty($ud)) {
            $uid = $ud->id;
        } else {
            return response()->json(['data' => 'Profile not updated, please try again', 'code' => 0]);
        }
        $update_Portfolio_user = UserPortfolio::where('id', $request->id)->first();

        $update_Portfolio_user->title = stripslashes($request->title);
        $update_Portfolio_user->description = stripslashes($request->description);
        $update_Portfolio_user->start_date = $request->start_date;
        $update_Portfolio_user->end_date = $request->end_date;
        $update_Portfolio_user->user_id = $uid;
        $update_Portfolio_user->created_at = Carbon::now(config('app.timezone'));
        $update_Portfolio_user->save();



        $ext = ".jpg";
        // dd($request->file('gallery_image'));
        if ($request->file('gallery_image') != null) {
            //delete old skills
            UserPortfolioImage::where('portfolio_id', $request->id)->delete();
            foreach ($request->file('gallery_image') as $key => $gallery_image) {
                // $image_file_path = $gallery_image;
                // $random_name = CustomFunction::random_string(20);
                // $uploaded_filename = $random_name . $ext;
                // $path = file_folder . $uploaded_filename;
                // $path_image_file = $image_file_path->getPathName();
                // $dest_image = 'public/' . UserPortfolio::getPortfolioImageDir($request->id) . $uploaded_filename;
                // Storage::disk('local')->put($dest_image, File::get($path_image_file));
				
				$data = date('Y/m/d');
				$hour = date('H');
				$path = 'profile/images/'.$data.'/'.$hour.'-'.$uid;
				$uploaded_filename = imageuploads3($path,$gallery_image);

                $update_user_portfolio_image = new UserPortfolioImage();
                $update_user_portfolio_image->portfolio_id = $request->id;
                $update_user_portfolio_image->filename = $uploaded_filename;
                $update_user_portfolio_image->type = 'image';
                $update_user_portfolio_image->created_at = Carbon::now(config('app.timezone'));
                $update_user_portfolio_image->save();
            }
        }


        $skills = json_decode($request->skill);
        if (!empty($skills)) {
            //delete old skills
            UserPortfolioSkill::where('user_id', $uid)->where('portfolio_id', $request->id)->delete();
            foreach ($skills as $skill) {
                $update_skill = new UserPortfolioSkill();
                $update_skill->portfolio_id = $request->id;
                $update_skill->skill_id = isset($skill->skill_id)?$skill->skill_id:$skill->id;
                $update_skill->user_id = $uid;
                $update_skill->created_at = Carbon::now(config('app.timezone'));
                $update_skill->save();
            }
        }



        if ($update_Portfolio_user) {
            return response()->json([
                        'data' => 'project  updated successfully',
                        'code' => 1,
                        'user' => $update_Portfolio_user
            ]);
        } else {
            return response()->json(['data' => 'Profile skill not updated, please try again', 'code' => 0]);
        }
    }
    public function doSendUserInvite(Request $request){
       // dd($request->all());
        $sender_email = User::select('email')->where('id', (int)$request->user_id)->first();
        $invite_to = User::select('*')->where('email', $request->invite_to_email)->first();

        $site_data = GeneralSetting::getAllDetails();
        $logo = file_path . '/' . $site_data['header_logo'];
        $site_name = config('app.APP_NAME');
        $support_signature = config('app.support_signature', '');
        $site_home_url = config('app.url');

        $project_link = $site_home_url.'/project'.'/'.$request->project['name'];
        $project_name = $request->project['name'];
        $invite_msg = $request->inviteMsg;
        $site_data = GeneralSetting::getAllDetails();
                $logo = file_path . '/' . $site_data['header_logo'];
        $subject = 'You have received invitation at ' . $site_name . ' site ';
        Mail::to($request->invite_to_email)->send(
            new SendgridMail(
            'emails.sendinvite',
                    $sender_email->email, [], $invite_msg,
    ["project_name"=>$project_name,"logo"=>$logo,'name'=>$invite_to->full_name
           ,'project_name'=>$project_name  ,'sender_email'=>  $request->invite_to_email,
        'invite_msg'=>     $invite_msg
            ,'project_link'=>$project_link
    ])
    );
    return response()->json([
        'message' => 'Invitation sent successfully.'
    ]);
        // dd('in the user invite', $request->all(), $sender_email);


    }

    public function doAddUserProfileSkill(Request $request) {
//        if (!isset($request->title) || $request->title == "") {
//            return response()->json(['data' => 'Please enter title', 'code' => 0]);
//        }
        // dd($request->skill);
        $ud = auth()->user();
        if (!empty($ud)) {
            $uid = $ud->id;
        } else {
            return response()->json(['data' => 'Profile not updated, please try again', 'code' => 0]);
        }
        $UserCategory_check = UserCategory::where('category_id',$request->cateogry['id'])->where('user_id',$uid)->get()->toArray();
        if (!empty($UserCategory_check)) {

            return response()->json(['data' => 'Category already exist, please try again with different', 'code' => 0]);
        }
        $update_category_user = new UserCategory();
        $update_category_user->category_id = $request->cateogry['id'];
        $update_category_user->user_id = $uid;
        $update_category_user->created_at = Carbon::now(config('app.timezone'));
        $update_category_user->save();

        foreach ($request->skill as $skill) {
            $update_user = new UserCategorySkill();
            $update_user->category_id = $request->cateogry['id'];
            $update_user->skill_id = $skill['id'];
            $update_user->user_id = $uid;
            $update_user->created_at = Carbon::now(config('app.timezone'));
            $update_user->save();
        }

        if ($update_category_user) {
            return response()->json([
                        'data' => 'Profile skill updated successfully',
                        'code' => 1,
                        'user' => $update_user
            ]);
        } else {
            return response()->json(['data' => 'Profile skill not updated, please try again', 'code' => 0]);
        }
    }

    public function doUpdateUserProfileSkill(Request $request) {
//        if (!isset($request->title) || $request->title == "") {
//            return response()->json(['data' => 'Please enter title', 'code' => 0]);
//        }
        // dd($request->skill);
        $ud = auth()->user();
        if (!empty($ud)) {
            $uid = $ud->id;
        } else {
            return response()->json(['data' => 'Profile not updated, please try again', 'code' => 0]);
        }
        //dd($request->skill);
        UserCategorySkill::where('user_id', $uid)->where('category_id', $request->cateogry)->delete();

        $update_user_status = false;
        foreach ($request->skill as $skill) {
            $skill_id = isset($skill['skill_id']) ? $skill['skill_id'] : $skill['id'];
            $update_user = new UserCategorySkill();
            $update_user->category_id = $request->cateogry;
            $update_user->skill_id = $skill_id;
            $update_user->user_id = $uid;
            $update_user->created_at = Carbon::now(config('app.timezone'));

            $update_user->save();
            $update_user_status = true;
        }
        if ($update_user_status == true) {
            return response()->json([
                        'data' => 'Profile skill updated successfully',
                        'code' => 1,
                        'user' => $update_user
            ]);
        } else {
            return response()->json(['data' => 'Profile skill not updated, please try again', 'code' => 0]);
        }
    }

    public function doUpdateUserProfileLanguage(Request $request) {

        $ud = auth()->user();
        if (!empty($ud)) {
            $uid = $ud->id;
        } else {
            return response()->json(['data' => 'Profile not updated, please try again', 'code' => 0]);
        }

        UserLanguage::where('user_id', $uid)->delete();

        $update_user_status = false;
        foreach ($request->languages as $language) {
            $update_user_language = new UserLanguage();
            $update_user_language->language = $language['text'];
            $update_user_language->user_id = $uid;
            $update_user_language->created_at = Carbon::now(config('app.timezone'));
            $update_user_language->save();
            $update_user_status = true;
        }
        if ($update_user_status == true) {
            return response()->json([
                        'data' => 'Profile language updated successfully',
                        'code' => 1,
                        'user' => $update_user_status
            ]);
        } else {
            return response()->json(['data' => 'Profile language not updated, please try again', 'code' => 0]);
        }
    }

    public function deleteUserProfileCayegory(Request $request) {
        $ud = auth()->user();
        $postData = $request->all();
        if (!empty($ud)) {
            $uid = $ud->id;
        } else {
            return response()->json(['data' => 'Profile not updated, please try again', 'code' => 0]);
        }
        UserCategory::where('user_id', $uid)->where('category_id', $postData['category'])->delete();
        UserCategorySkill::where('user_id', $uid)->where('category_id', $postData['category'])->delete();
        return response()->json([
                    'data' => 'Profile skill delete successfully',
                    'code' => 1,
                    'user' => $ud
        ]);
    }

    public function getUserProfile(Request $request) {
        $User = auth()->user();
        $default_user_avatar_url = config('app.empty_default_user_avatar_url');
        $default_user_cover_url = config('app.empty_img_url');

        if (!empty($User->profile_photo)) {            
            $loggedUserProfilePhotoImageProps = User::readUserImageProps($User->id, $User->profile_photo ?? $default_user_avatar_url, true);
            if (empty($loggedUserProfilePhotoImageProps)) {
                $loggedUserProfilePhotoImageProps['image_url'] = $default_user_avatar_url;
            }
        } else {
            $loggedUserProfilePhotoImageProps['image_url'] = $default_user_avatar_url;
        }


        if (!empty($User->cover_image)) {
            $UserCoverPhotoImageProps = User::readUserCoverProps($User->id, $User->cover_image ?? $default_user_avatar_url, true);
            if (empty($UserCoverPhotoImageProps)) {
                $UserCoverPhotoImageProps['image_url'] = $default_user_cover_url;
            }
        } else {
            $UserCoverPhotoImageProps['image_url'] = $default_user_cover_url;
        }
        
        $categories = DB::table('user_category')
                ->join('category', 'category.id', '=', 'user_category.category_id')
                ->select('user_category.*', 'category.title')
                ->where('user_category.user_id', $User->id)
                //->groupBy('user_category_skill.category_id')
                ->get();

        foreach ($categories as $k => $category) {
            //$categories[$k]['skill']
            $skill = DB::table('user_category_skill')
                    ->join('tag', 'tag.id', '=', 'user_category_skill.skill_id')
                    ->select('user_category_skill.*', 'tag.title', 'tag.title as text')
                    ->where('user_category_skill.user_id', $User->id)
                    ->where('user_category_skill.category_id', $category->category_id)
                    //->groupBy('user_category_skill.category_id')
                    ->get();
            $categories[$k]->skills = $skill;
        }


        $portfolios = DB::table('user_portfolio')
                ->select('user_portfolio.*')
                ->where('user_portfolio.user_id', $User->id)
                //->groupBy('user_category_skill.category_id')
                ->get();
        foreach ($portfolios as $k => $portfolio) {
            //$categories[$k]['skill']
            $skill = DB::table('user_portfolio_skill')
                    ->join('tag', 'tag.id', '=', 'user_portfolio_skill.skill_id')
                    ->select('user_portfolio_skill.*', 'tag.title', 'tag.title as text')
                    ->where('user_portfolio_skill.user_id', $User->id)
                    ->where('user_portfolio_skill.portfolio_id', $portfolio->id)
                    //->groupBy('user_category_skill.category_id')
                    ->get();
            $portfolios[$k]->skills = $skill;
            $UserPortfolioImages = UserPortfolioImage::where('portfolio_id', $portfolio->id)->get();
            foreach ($UserPortfolioImages as $i => $UserPortfolioImage) {
                $UserPortfolioImages[$i] = UserPortfolio::readPortfolioImageProps($portfolio->id, $UserPortfolioImage->filename, true, $UserPortfolioImage->id);
            }
            $portfolios[$k]->gallery_images = $UserPortfolioImages;
//            $skill = DB::table('user_portfolio_skill')
//                    ->join('tag', 'tag.id', '=', 'user_portfolio_skill.skill_id')
//                    ->select('user_portfolio_skill.*', 'tag.title', 'tag.title as text')
//                    ->where('user_portfolio_skill.user_id', $User->id)
//                    ->where('user_portfolio_skill.portfolio_id', $portfolio->id)
//                    //->groupBy('user_category_skill.category_id')
//                    ->get();
//            if(isset($categories[$k])){
//                $categories[$k]->skills = $skill;
//            }

        }
        $logged_user_id = $User->id;
        $communities = Community
                        ::getByStatus(true)
                        // ->getExtendedSearch($request->search_text)
                        //->getByTags($request->tags ?? [])
                        ->withCount('UserCommunityVote')
                        ->withCount('UserCommunityViewed')
                        ->withCount('CommunityAnswer')
                        ->with('CommunityTagTagged.Tag')
                        ->with('user')
                        ->where('user_id', $User->id)
                        ->orderBy('community.id', 'desc')
                        ->get()
                        ->map(function ($communityItem) use ($logged_user_id) {
                            $communityItem['is_new'] = false;
                            $communityItem['is_already_voted'] = false;
                            if (!empty($logged_user_id) && $logged_user_id == 'null') {
                                $loggedUserCommunityViewedCount = UserCommunityViewed
                                        ::getByCommunityId($communityItem->id)
                                        ->getByUserId($logged_user_id)
                                        ->count();
                                $communityItem['is_new'] = $loggedUserCommunityViewedCount == 0;
                                if ($loggedUserCommunityViewedCount == 0) {
                                    $userCommunityViewed = new UserCommunityViewed();
                                    $userCommunityViewed->community_id = $communityItem->id;
                                    $userCommunityViewed->user_id = $logged_user_id;
                                    $userCommunityViewed->save();
                                }

                                $loggedUserCommunityVotesCount = UserCommunityVote
                                        ::getByCommunityId($communityItem->id)
                                        ->getByUserId($logged_user_id)
                                        ->count();
                                $communityItem['is_already_voted'] = $loggedUserCommunityVotesCount > 0;
                            }

                            return $communityItem;
                        })->all();

        //  dd($communities);
        $userlanguage = DB::table('user_language')
                ->select('user_language.*', 'user_language.language as text')
                ->where('user_language.user_id', $User->id)
                ->get();

        $page = (int) $request->page ?? 1;
        $recordPerPageConfig = Config::get('constant.record_per_page');
        $limit = 12;
        $start = $limit * ($page - 1);
        $query = Project::getByStatus('A')->with('category')->with('creator')
                ->with('ProjectImage', function($query) {
                    $query->where('project_image.type', '=', 'image');
                })
                ->orderBy('project.created_at', 'desc');

        $query = $query->where('project.user_id', $User->id);

        $projects = $query->offset($start)->limit($limit)
                        ->get()
                        ->map(function ($projectItem) use ($logged_user_id) {
                            $default_user_avatar_url = config('app.empty_default_user_avatar_url');
                            $projectItem->creator_full_name = $projectItem->creator->full_name ?? '';
                            $projectItem->created_at_formatted = getCFFormattedDateTime($projectItem->created_at);
                            $userProfilePhotoImageProps = ['image_url' => $default_user_avatar_url];
                            if (!empty($projectItem->creator->profile_photo)) {
                                $userProfilePhotoImageProps['image_url'] = $projectItem->creator->profile_photo;
                            }

                            $projectItem['creatorUserProfilePhotoImageProps'] = $userProfilePhotoImageProps;

                            $empty_img_url = config('app.empty_img_url');
                            if (isset($projectItem->ProjectImage) && count($projectItem->ProjectImage->toArray()) > 0) {
                                $projectImageItemImgProps['image_url'] = $projectItem->ProjectImage[0]->filename;
                            } else {
                                $projectImageItemImgProps['image_url'] = $empty_img_url;
                            }
                            $projectItem->projectImagePropsArray = $projectImageItemImgProps;
                            //unset image array once image added to response var
                            unset($projectItem->ProjectImage);



                            if (isset($projectItem['category'][0]['category_id'])) {
                                $Category = Category::select('title')->where(['id' => $projectItem['category'][0]['category_id']])->first();
                                $projectItem->categoryname = $Category['title'];
                            }
                            return $projectItem;
                        })->toArray();

        return response()->json([
                    'User' => $User,
                    'communities' => $communities,
                    'categories' => $categories,
                    'projects' => $projects,
                    'portfolio' => $portfolios,
                    'userlanguage' => $userlanguage,
                    'UserCoverPhotoImageProps' => $UserCoverPhotoImageProps,
                    'UserProfilePhotoImageProps' => $loggedUserProfilePhotoImageProps,
                        ], HTTP_RESPONSE_OK);
    }

    /**
     * IN USE
     * @param Request $request
     * @return type
     */
    public function getUserDashboard(Request $request) {
        try {
            $User = auth()->user();
            $default_user_avatar_url = config('app.empty_default_user_avatar_url');
            $default_user_cover_url = config('app.empty_img_url');

            if (!empty($User->profile_photo)) {
                $loggedUserProfilePhotoImageProps = User::readUserImageProps($User->id, $User->profile_photo ?? $default_user_avatar_url, true);
                if (empty($loggedUserProfilePhotoImageProps)) {
                    $loggedUserProfilePhotoImageProps['image_url'] = $default_user_avatar_url;
                }
            } else {
                $loggedUserProfilePhotoImageProps['image_url'] = $default_user_avatar_url;
            }


    //        if (!empty($User->cover_image)) {
    //            $UserCoverPhotoImageProps = User::readUserCoverProps($User->id, $User->cover_image ?? $default_user_avatar_url, true);
    //            if (empty($UserCoverPhotoImageProps)) {
    //                $UserCoverPhotoImageProps['image_url'] = $default_user_cover_url;
    //            }
    //        } else {
    //            $UserCoverPhotoImageProps['image_url'] = $default_user_cover_url;
    //        }

            $logged_user_id = $User->id;
            $communities = Community
                            ::getByStatus(true)
                            // ->getExtendedSearch($request->search_text)
                            //->getByTags($request->tags ?? [])
                            ->withCount('UserCommunityVote')
                            ->withCount('UserCommunityViewed')
                            ->withCount('CommunityAnswer')
                            ->with('CommunityTagTagged.Tag')
                            ->with('user')
                            ->where('user_id', $User->id)
                            ->orderBy('community.id', 'desc')
                            ->get()
                            ->map(function ($communityItem) use ($logged_user_id) {
                                $communityItem['is_new'] = false;
                                $communityItem['is_already_voted'] = false;
                                if (!empty($logged_user_id) && $logged_user_id == 'null') {
                                    $loggedUserCommunityViewedCount = UserCommunityViewed
                                            ::getByCommunityId($communityItem->id)
                                            ->getByUserId($logged_user_id)
                                            ->count();
                                    $communityItem['is_new'] = $loggedUserCommunityViewedCount == 0;
                                    if ($loggedUserCommunityViewedCount == 0) {
                                        $userCommunityViewed = new UserCommunityViewed();
                                        $userCommunityViewed->community_id = $communityItem->id;
                                        $userCommunityViewed->user_id = $logged_user_id;
                                        $userCommunityViewed->save();
                                    }

                                    $loggedUserCommunityVotesCount = UserCommunityVote
                                            ::getByCommunityId($communityItem->id)
                                            ->getByUserId($logged_user_id)
                                            ->count();
                                    $communityItem['is_already_voted'] = $loggedUserCommunityVotesCount > 0;
                                }

                                return $communityItem;
                            })->all();

            $query = Project
                    ::getByStatus('A')
                    ->with('category')
                    ->with('creator')
                    ->orderBy('project.created_at', 'desc');

            $query = $query->where('project.user_id', $User->id);

            $projects = $query->get()
                            ->map(function ($projectItem) use ($logged_user_id) {
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

                                $projectImageMainItem = ProjectImage
                                        ::getByProjectId($projectItem->id)
                                        ->getByIsMain(true)
                                        ->first();
                                $empty_img_url = config('app.empty_img_url');
                                if (!empty($projectImageMainItem->project_id)) {
                                    $projectImageItemImgProps = ProjectImage::readProjectImageProps($projectImageMainItem->project_id, $projectImageMainItem->filename ?? $empty_img_url, true);
                                    $projectImageItemImgProps['info'] = $projectImageMainItem->info;
                                } else {
                                    $projectImageItemImgProps['image_url'] = $empty_img_url;
                                    $projectImageItemImgProps['info'] = "Default project image";
                                }
                                $projectItem->projectImagePropsArray = $projectImageItemImgProps;

                                if (isset($projectItem['category'][0]['category_id'])) {
                                    $Category = Category::select('title')->where(['id' => $projectItem['category'][0]['category_id']])->first();
                                    $projectItem->categoryname = $Category['title'];
                                }
                                return $projectItem;
                            })->toArray();

                $query_pending = Project
                    ::getByStatus('D')
                    ->with('category')
                    ->with('creator')
                    ->orderBy('project.created_at', 'desc');

            $query_pending = $query_pending->where('project.user_id', $User->id);

            $projects_pending = $query_pending->get()
                            ->map(function ($projectItem) use ($logged_user_id) {
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

                                $projectImageMainItem = ProjectImage
                                        ::getByProjectId($projectItem->id)
                                        ->getByIsMain(true)
                                        ->first();
                                $empty_img_url = config('app.empty_img_url');
                                if (!empty($projectImageMainItem->project_id)) {
                                    $projectImageItemImgProps = ProjectImage::readProjectImageProps($projectImageMainItem->project_id, $projectImageMainItem->filename ?? $empty_img_url, true);
                                    $projectImageItemImgProps['info'] = $projectImageMainItem->info;
                                } else {
                                    $projectImageItemImgProps['image_url'] = $empty_img_url;
                                    $projectImageItemImgProps['info'] = "Default project image";
                                }
                                $projectItem->projectImagePropsArray = $projectImageItemImgProps;

                                if (isset($projectItem['category'][0]['category_id'])) {
                                    $Category = Category::select('title')->where(['id' => $projectItem['category'][0]['category_id']])->first();
                                    $projectItem->categoryname = $Category['title'];
                                }
                                return $projectItem;
                            })->toArray();


            ///company
            $query_company = \App\Models\Company::with('creator')
                    ->where(['company.user_id' => $User->id, 'is_deleted' => 0])
                    ->orderBy('company.created_at', 'desc')->get();

            $company = $query_company->map(function ($companyItem) use ($logged_user_id) {
                                $default_user_avatar_url = config('app.empty_default_user_avatar_url');
                                $companyItem->creator_full_name = $companyItem->creator->full_name ?? '';
                                $companyItem->created_at_formatted = getCFFormattedDateTime($companyItem->created_at);
                                $userProfilePhotoImageProps = ['image_url' => $default_user_avatar_url];
                                if (!empty($companyItem->creator->profile_photo)) {
                                    $userProfilePhotoImageProps = User::readUserImageProps($companyItem->creator->id, $companyItem->creator->profile_photo ?? $default_user_avatar_url, true);
                                    if (empty($userProfilePhotoImageProps['image_url'])) {
                                        $userProfilePhotoImageProps['image_url'] = $default_user_avatar_url;
                                    }
                                }
                                $companyItem['creatorUserProfilePhotoImageProps'] = $userProfilePhotoImageProps;
                                $companyImageMainItem = \App\Models\CompanyImage
                                        ::getByCompanyId($companyItem->id)
                                        ->getByType('logo')
                                        ->first();
                                $empty_img_url = config('app.empty_img_url');
                                if (!empty($companyImageMainItem->company_id)) {
                                    // $companyImageItemImgProps = \App\Models\CompanyImage::readCompanyImageProps($companyImageMainItem->company_id, $companyImageMainItem->filename ?? $empty_img_url, true);
                                    $companyImageItemImgProps['image_url'] = $companyImageMainItem->filename;
                                    $companyImageItemImgProps['info'] = $companyImageMainItem->info;
                                } else {
                                    $companyImageItemImgProps['image_url'] = $empty_img_url;
                                    $companyImageItemImgProps['info'] = "Default company image";
                                }
                                $companyItem->companyImagePropsArray = $companyImageItemImgProps;                        
                                return $companyItem;
                            })->toArray();

                        ///brand

            $query_brand = \App\Models\Brand::where(['is_deleted' => 0])->with('creator')
                    ->orderBy('brand.created_at', 'desc');
            $query_brand = $query_brand->where('brand.user_id', $User->id);
            $brand = $query_brand->get()
                            ->map(function ($brandItem) use ($logged_user_id) {
                                $default_user_avatar_url = config('app.empty_default_user_avatar_url');
                                $brandItem->creator_full_name = $brandItem->creator->full_name ?? '';
                                $brandItem->created_at_formatted = getCFFormattedDateTime($brandItem->created_at);
                                $userProfilePhotoImageProps = ['image_url' => $default_user_avatar_url];
                                if (!empty($companyItem->creator->profile_photo)) {
                                    $userProfilePhotoImageProps = User::readUserImageProps($brandItem->creator->id, $brandItem->creator->profile_photo ?? $default_user_avatar_url, true);
                                    if (empty($userProfilePhotoImageProps['image_url'])) {
                                        $userProfilePhotoImageProps['image_url'] = $default_user_avatar_url;
                                    }
                                }
                                $brandItem['creatorUserProfilePhotoImageProps'] = $userProfilePhotoImageProps;
                                $brandImageMainItem = \App\Models\BrandImage
                                        ::getByBrandId($brandItem->id)
                                        ->getByType('logo')
                                        ->orderBy('id', 'DESC')
                                        ->first();
                                $empty_img_url = config('app.empty_img_url');
                                $brandImageArr['image_url'] = $empty_img_url;
                                $brandImageArr['info'] = "Default company image";
                                    
                                if (!empty($brandImageMainItem)) {
                                    $brandImageArr['image_url'] = $brandImageMainItem->filename;
                                    $brandImageArr['info'] = $brandImageMainItem->info;
                                }
                                $brandItem->brandImagePropsArray = $brandImageArr;                        
                                return $brandItem;
                            })->toArray();
                            
            $productSelectArr = ['product.id', 'product.name', 'product.slug', 'product.desc', 
                'product.short_desc'];
            $approvedProduct = Product::select($productSelectArr)->withcount('likescount')->where('user_id', $User->id)->where('is_approved', 'A')->get();
            $pendingProduct = Product::select($productSelectArr)->withcount('likescount')->where('user_id', $User->id)->where('is_approved', '!=', 'A')->get();

            return $this->success([
                        'user' => $User,
                        'communities' => $communities,
                        'projects' => $projects,
                        'projects_pending' => $projects_pending,
                        'approved_product' => $approvedProduct,
                        'product_pending' => $pendingProduct,
                        'company' => $company,
                        'brand' => $brand,
                        'user_cover_photo_image_props' => $loggedUserProfilePhotoImageProps,
                            ], "Dashboard data");
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }

    public function doUpdateUserPassword(Request $request) {

        if (!isset($request->new_pass) || $request->new_pass == "") {
            return response()->json(['data' => 'Please enter New password', 'code' => 0]);
        }

        $ud = auth()->user();
        $uid = 0;
        if (!empty($ud)) {
            $uid = $ud->id;
            if ($ud->utype == 0) {
                $old_password = $ud->password;
                if (!isset($request->current_pass) || $request->current_pass == "") {
                    return response()->json(['data' => 'Please enter Current password', 'code' => 0]);
                }

                if (!Hash::check($request->current_pass, $old_password)) {
                    return response()->json(['data' => 'Current password does not match', 'code' => 0]);
                }
            }
        } else {
            return response()->json(['data' => 'Password not update, please try again', 'code' => 0]);
        }

        $current_pass = "";
        if (isset($request->current_pass) && $request->current_pass != "") {
            $current_pass = $request->current_pass;
            $password_current_hash = Hash::make($current_pass);
        }

        $new_pass = $request->new_pass;
        $password_hash = Hash::make($new_pass);

        $update_user = User::where('id', $uid)->first();
        $update_user->password = $password_hash;

        if ($update_user->save()) {
            return response()->json(['data' => 'Password updated successfully.', 'code' => 1]);
        } else {
            return response()->json(['data' => 'Password not update, please try again', 'code' => 0]);
        }
    }

    public function addUpdateServices(Request $request){
        $userData       = auth()->user();
        $serviceName    = $request->service_name;
        $isChecked      = $request->is_checked;
        
        $update_user    = User::where('id', $userData->id)->first();
        if($update_user->services == null){
            $update_user->services = $serviceName;
        }else{
            $serviceArray = explode(",", $update_user->services);
            if($isChecked){
                array_push($serviceArray, $serviceName);
            }else{
                $serviceArray = array_filter($serviceArray, static function ($element) use($serviceName) {
                    return $element !== $serviceName;
                });
            }
            $update_user->services = implode(",", $serviceArray);
        }

        if ($update_user->save()) {
            return response()->json(['message' => 'Services updated successfully.', 'status' => true]);
        } else {
            return response()->json(['message' => 'Services not update, please try again', 'status' => false]);
        }
    }

}
