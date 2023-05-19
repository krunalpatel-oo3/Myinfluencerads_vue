<?php

namespace App\Http\Controllers\api;

use App\Mail\UserRegistered;
use App\Mail\SendgridMail;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use JWTAuth;
use Hash;
use Mail;
use Config;
use Image;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use App\Models\{User, UserCategorySkill, Project, Category, Community, UserCommunityViewed, UserCommunityVote, Product, ProductReviews};
use App\Models\GeneralSetting;
use App\Models\PlanUserAssoc;
use Validator;
use App\CustomFunction\CustomFunction;
use App\CustomFunction\LinkedIn;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\IpUtils;
use DB;
use App\Helpers\EmailTrait;


class LoginApiController extends BaseController {

    use EmailTrait;

    public function isLoggedIn(Request $request) {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            return response()->json(['data' => 'Success', 'code' => 1], 200);
        } catch (\Exception $exc) {
            return response()->json(['data' => 'Invalid Token', 'code' => 0], 401);
        }

        return response()->json(['data' => 'Invalid Token', 'code' => 0], 401);
    }

    /**
     *
     * @param Request $request
     *
     * @return type
     */
    public function doLogin(Request $request) {
        if (!isset($request->email) || $request->email == "") {
            return response()->json(['data' => 'Invalid request, please try again.', 'code' => 0]);
        }
        if (!CustomFunction::validate_input($request->email, 'email')) {
            return response()->json(['data' => 'Please enter valid Email', 'code' => 0]);
        }
        if (!isset($request->password) || $request->password == "") {
            return response()->json(['data' => 'Invalid request, please try again.', 'code' => 0]);
        }

        $email = CustomFunction::filter_input($request->email);
        $password = CustomFunction::filter_input($request->password);

        $is_found_email = User::where('email', $email)->get()->toArray();
//        \Log::info(varDump($is_found_email, ' -1 doLogin $is_found_email::'));
//        \Log::info(varDump($email, ' -1 doLogin $email::'));
//        \Log::info(varDump($password, ' -1 doLogin $password::'));
        if (!empty($is_found_email)) {
            $logged_user_id = $is_found_email[0]['id'];
            $status = $is_found_email[0]['status'];
            $email_confirm = $is_found_email[0]['email_confirm'];
            $full_name = $is_found_email[0]['full_name'];
            $login = $is_found_email[0]['login'];
            $profile_photo = $is_found_email[0]['profile_photo'];
            
            if ($email_confirm == '0')
                return response()->json(['data' => 'Please Verify your email first and try to do a login', 'code' => 0]);
            if ($status == '0') 
                return response()->json(['data' => 'Your A/c is disabled, please contact admin for more information', 'code' => 0 ]);
        } else {
            return response()->json(['data' => 'Incorrect Email address or password', 'code' => 0]);
        }

        $token = JWTAuth::attempt([
                    'email' => $email,
                    'password' => $password,
                    'urole' => user_role
                        ]
        );
//        \Log::info(varDump($token, ' -1 $token::'));

        if ($token) {

            $update_user = User::where('email', $email)->first();
            $update_user->utype = reg_user;
            $update_user->save();

            return response()->json([
                        'data' => 'Login successfully',
                        'code' => 1,
                        'token' => $token,
                        'full_name' => $full_name,
                        'login' => $login,
                        'profile_photo' => $profile_photo,
                        'logged_user_id' => $logged_user_id
            ]);
        } else {
            return response()->json(['data' => 'Incorrect Email address or Password', 'code' => 0]);
        }
    }

    /**
     *
     * @param Request $request
     */
    public function doFacebookLogin(Request $request) {
        if (!isset($request->token) || $request->token == "") {
            return response()->json(['data' => 'Details not sent, please try again.', 'code' => 0]);
        }
        if (!isset($request->user) || $request->user == "" || !is_numeric($request->user)) {
            return response()->json(['data' => 'Details not sent, please try again.', 'code' => 0]);
        }

        $token = CustomFunction::filter_input($request->token);
        $userid = CustomFunction::filter_input($request->user);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://graph.facebook.com/v9.0/$userid?fields=id,name,email&access_token=" . $token,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if (!$err) {
            $response_decode = json_decode($response, true);
            if (array_key_exists("name", $response_decode)) {

                if (!array_key_exists("email", $response_decode)) {
                    return response()->json([
                                'data' => 'Please give email permission to Login using Facebook',
                                'code' => 0
                    ]);
                }

                $fb_user_name = $response_decode['name'];
                $fb_user_email = $response_decode['email'];

                // is user exists
                $is_exists = User::getUserDetails($fb_user_email, 'email');

                if (empty($is_exists)) {
                    // create new user
                    $new_user = new User;
                    $new_user->full_name = $fb_user_name;
                    $new_user->email = $fb_user_email;
                    $new_user->status = '1';
                    $new_user->email_confirm = '1';
                    $new_user->urole = user_role;
                    $new_user->utype = fb_user;
                    $new_user->facebook_id = $userid;
                    $new_user->facebook_name = $fb_user_name;
                    $new_user->login = $fb_user_name;
//                    $new_user->login_token = $random_token;
                    if ($new_user->save()) {

                        /* ==== create JWT Token - start ==== */
                        $user_obj = User::where('email', $fb_user_email)->first();

                        try {
                            if (!$random_token = JWTAuth::fromUser($user_obj)) {
                                return response()->json(['data' => 'Login not done, please try again', 'code' => 0]);
                            }
                        } catch (\Exception $e) {
                            return response()->json(['data' => 'Login not done, please try again', 'code' => 0]);
                        }

                        /* ==== create JWT Token - end ==== */
                        
                        PlanUserAssoc::assocUserWithOrder(1, $user_obj->id); //associate free plan with user

                        return response()->json([
                                    'data' => 'Login successfully',
                                    'code' => 1,
                                    'token' => $random_token,
                                    'email' => $fb_user_email,
                                    'name' => $fb_user_name,
                                    'photo' => ''
                        ]);
                    } else {
                        return response()->json(['data' => 'Login not done, please try again', 'code' => 0]);
                    }
                } else {

                    $update_user = User::where('email', $fb_user_email)->first();
                    $photo = $update_user->profile_photo;

                    $update_user->utype = fb_user;
//                    $update_user->facebook_id = $userid;
//                    $update_user->login_token = $random_token;
                    $update_user->save();

                    /* ==== create JWT Token - start ==== */
                    try {
                        if (!$random_token = JWTAuth::fromUser($update_user)) {
                            return response()->json(['data' => 'Login not done, please try again', 'code' => 0]);
                        }
                    } catch (\Exception $e) {
                        return response()->json(['data' => 'Login not done, please try again', 'code' => 0]);
                    }

                    /* ==== create JWT Token - end ==== */

                    return response()->json([
                                'data' => 'Login successfully',
                                'code' => 1,
                                'token' => $random_token,
                                'email' => $fb_user_email,
                                'name' => $fb_user_name,
                                'photo' => $photo
                    ]);
                }
            }
        }

        return response()->json(['data' => 'Details not sent, please try again.', 'code' => 0]);
    }

    /**
     *
     * @param Request $request
     *
     * @return type
     */
    public function doGoogleLogin(Request $request) {
        try {
            DB::beginTransaction();
            if (!isset($request->name) || $request->name == "") {
                return response()->json(['data' => 'Details not sent, please try again.', 'code' => 0]);
            }
            if (!isset($request->email) || $request->email == "") {
                return response()->json(['data' => 'Details not sent, please try again.', 'code' => 0]);
            }
            if (!CustomFunction::validate_input($request->email, 'email')) {
                return response()->json(['data' => 'Details not sent, please try again.', 'code' => 0]);
            }
            if (!isset($request->user) || $request->user == "" || !is_numeric($request->user)) {
                return response()->json(['data' => 'Details not sent, please try again.', 'code' => 0]);
            }

            $name = CustomFunction::filter_input($request->name);
            $email = CustomFunction::filter_input($request->email);
            $userid = CustomFunction::filter_input($request->user);

            $is_exists = User::getUserDetails($email, 'email');

            if (empty($is_exists)) {// if email not found then create new0
                $password = Str::random(8); //substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), -5);
                $password_hash = Hash::make($password);
                $new_user = new User;
                $new_user->full_name = $name;
                $new_user->email = $email; //' google account ... ' . $userid;
                $new_user->status = '1';
                $new_user->email_confirm = '1';
                $new_user->password = $password_hash;
                $new_user->google_id = $userid;
                $new_user->google_name = $name;
                $new_user->login = $name;
                $new_user->user_type = 'normal';
                $new_user->email_confirm = '1';
                $new_user->utype = '2';
                $new_user->urole = user_role;

                $location_details = $this->IPtoLocation($request->ip()) ?? '';
                if($location_details != '') {
                    $location_reg = $location_details ? $location_details->region_name.', '.$location_details->country_name : ' ';
                    $new_user->ip = $location_details->ip ?? ' ';
                    $new_user->location = $location_reg ?? ' ';
                    $new_user->timezone = $location_details->time_zone ?? ' ';
                    $new_user->country = $location_details->country_name ?? ' ';
                    $new_user->city = $location_details->city ?? ' ';
                    $new_user->postal_code = $location_details->zip_code ?? ' ';
                }
                $new_user->updated_at = Carbon::now(config('app.timezone'));

                if ($new_user->save()) {
                    $userObj = User::where('email', $email)->first();

                    if (!$random_token = JWTAuth::fromUser($userObj)) {
                        throw new Exception('Login not done, please try again');
                    }

                     // send confirmation email
                    $site_data = GeneralSetting::getAllDetails();
                    $logo = file_path . '/' . $site_data['header_logo'];

                    $emaildata = array(
                        'name' => $userObj->full_name,
                        'email' => $userObj->email,
                        'logo' => $logo,
                        'confirm_url' => "",
                        'template' => 'emails.registrationgoogle',
                        'subject' => 'You are registered at ' . config('app.APP_NAME') . ' site ',
                        'password' => $password,
                    );

                    $this->sendMail($emaildata);
                    
                    PlanUserAssoc::assocUserWithOrder(1, $userObj->id); //associate free plan with user
                    DB::commit();
                } else {
                    throw new Exception('Login not done, please try again');
                }
            } else { //if user found
                $userObj = User::where('email', $email)->first();

                if (!$random_token = JWTAuth::fromUser($userObj)) {
                    throw new Exception('Login not done, please try again');
                }
            }

            return response()->json([
                                        'data' => 'Login successfully', 'code' => 1,
                                        'token' => $random_token, 'name' => $userObj->full_name,
                                        'id' => $userObj->id, 'photo' => ''
                                    ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['data' => $e->getMessage(), 'code' => 0]);
        }
    }

    /**
     *
     * @param Request $request
     */
    public function doINLogin(Request $request) {
        $app_id = env('IN_APP_ID');
        $app_secret = env('IN_APP_SECRET');
        $callback = env('IN_CALLBACK');
        $scopes = env('IN_SCOPE');
        $ssl = env('IN_SSL'); //TRUE FOR PRODUCTION ENV.

        if (!isset($request->code) || $request->code == "") {
            return response()->json(['data' => 'Details not sent, please try again.', 'code' => 0]);
        }

        $incode = trim($request->code);

        $linkedin = new LinkedIn($app_id, $app_secret, $callback, $scopes, $ssl);

        $accessToken = $linkedin->getAccessToken($incode);

        $profileObject = $linkedin->getPerson();
        $emailObject = $linkedin->getEmail();

        $userid = $fname = $lname = $name = $email = "";
        if (!empty($profileObject->id)) {
            $userid = $profileObject->id;
        }
        if (!empty($profileObject->firstName->localized->en_US)) {
            $fname = $profileObject->firstName->localized->en_US;
        }
        if (!empty($profileObject->lastName->localized->en_US)) {
            $lname = $profileObject->lastName->localized->en_US;
        }
        if (!empty($emailObject->elements[0]->{'handle~'}->emailAddress)) {
            $email = $emailObject->elements[0]->{'handle~'}->emailAddress;
        }

        if ($userid == "" || $fname == "" || $lname == "" || $email == "") {
            return response()->json(['data' => 'Login not done, please try again1.', 'code' => 0]);
        }

        $name = $fname . ' ' . $lname;

        // is user exists
        $is_exists = User::getUserDetails($email, 'email');
        if (empty($is_exists)) {
            // create new user
            $new_user = new User;
            $new_user->full_name = $name;
            $new_user->email = $email;
            $new_user->status = '1';
            $new_user->email_confirm = '1';
            $new_user->urole = user_role;
            $new_user->utype = linkedin_user;
            $new_user->linkedin_id = $userid;
            $new_user->instagram_name = $name;
            $new_user->login = $name;
            $new_user->updated_at = Carbon::now(config('app.timezone'));
            if ($new_user->save()) {

                /* ==== create JWT Token - start ==== */
                $user_obj = User::where('email', $email)->first();

                try {
                    if (!$random_token = JWTAuth::fromUser($user_obj)) {
                        return response()->json(['data' => '2Login not done, please try again', 'code' => 0]);
                    }
                } catch (\Exception $e) {
                    return response()->json(['data' => '3Login not done, please try again', 'code' => 0]);
                }

                /* ==== create JWT Token - end ==== */

                return response()->json([
                            'data' => 'Login successfully',
                            'code' => 1,
                            'token' => $random_token,
                            'name' => $name,
                            'email' => $email
                ]);
            } else {
                return response()->json(['data' => 'Login not done, please try again', 'code' => 0]);
            }
        } else {

            $update_user = User::where('email', $email)->first();
            $photo = $update_user->profile_photo;

            $update_user->utype = linkedin_user;
            $update_user->linkedin_id = $userid;
            $update_user->linkedin_name = $update_user->full_name;
            $update_user->login = $update_user->full_name;
            $update_user->save();

            /* ==== create JWT Token - start ==== */
            try {
                if (!$random_token = JWTAuth::fromUser($update_user)) {
                    return response()->json(['data' => 'Login not done, please try again', 'code' => 0]);
                }
            } catch (\Exception $e) {
                return response()->json(['data' => 'Login not done, please try again', 'code' => 0]);
            }

            /* ==== create JWT Token - end ==== */

            return response()->json([
                        'data' => 'Login successfully',
                        'code' => 1,
                        'token' => $random_token,
                        'name' => $name,
                        'email' => $email,
                        'photo' => $photo
            ]);
        }

        return response()->json(['data' => 'Details not sent, please try again.', 'code' => 0]);
    }

    /**
     *
     * @param Request $request
     *
     * @return type
     */
    public function doRegister(Request $request) {
        try {
            DB::beginTransaction();
            $ip = '111.119.187.14';

            $login = CustomFunction::filter_input($request->login);
            $full_name = CustomFunction::filter_input($request->full_name);
            $email = CustomFunction::filter_input($request->email);
            $password = CustomFunction::filter_input($request->password);
            $password_hash = Hash::make($password);
            
            //return if password is less than 8 char
            if(strlen($password) < 8) {
                throw new Exception('Password length must be atleast 8 characters');
            }
            
            //return if email already found
            $is_found_email = User::where('email', $email)->count();
            if ($is_found_email > 0) {
                throw new Exception('This email address is already registered');
            }
            
            //return if login key already found
            $is_found_loginkey = User::where('login', $login)->count();
            if ($is_found_loginkey > 0) {
                throw new Exception('This username is already registered');
            }

            $random_no = CustomFunction::random_string(10);
            
            $location_reg = '';
            $location_details = $this->IPtoLocation($ip) ?? '';
            if(!empty($location_details)){
                $location_reg = $location_details->region_name.', '.$location_details->country_name;
            }

            $new_user = new User;
            $new_user->login = $login;
            $new_user->full_name = $full_name;
            $new_user->email = $email;
            $new_user->password = $password_hash;
//            $new_user->ip = $location_details->ip ?? ' ';
            $new_user->location = $location_reg ?? ' ';
            $new_user->email_confirm = '0';
            $new_user->urole = user_role;
            $new_user->email_key = $random_no;
            $new_user->updated_at = Carbon::now(config('app.timezone'));
            $new_user->timezone = $location_details->time_zone ?? ' ';
            $new_user->country = $location_details->country_name ?? ' ';
            $new_user->city = $location_details->city ?? ' ';
            $new_user->postal_code = $location_details->zip_code ?? ' ';
            $new_user->status = false;
            $new_user->user_type = 'normal';

            if ($new_user->save()) {
                PlanUserAssoc::assocUserWithOrder(1, $new_user->id); //associate free plan with user

                // send verification email
                $site_data = GeneralSetting::getAllDetails();
                $logo = file_path . '/' . $site_data['header_logo'];

                $confirm_url = url('verify-email/' . $random_no);

                $emaildata = array(
                    'name' => $full_name,
                    'email' => $email,
                    'logo' => $logo,
                    'confirm_url' => $confirm_url,
                    'template' => 'emails.registration',
                    'subject' => 'You are registered at ' . config('app.APP_NAME') . ' site '
                );

                $this->sendMail($emaildata);

                DB::commit();
                return response()->json([
                    'data' => 'Registration done successfully, please check your inbox to verify email address.',
                    'code' => 1
                ]);
            } else {
                throw new Exception('Registration not done, please try again');
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage(), 'code' => 0]);
        }
    }
    
    /**
     * IN USE
     * @param Request $request
     *
     * @return type
     */
    public function verifyEmail(Request $request, $token) {
        try {
            DB::beginTransaction();
            $token = CustomFunction::filter_input($token);
            
            $user = User::where("email_key", $token)->first();
            if($user == null){
                return view('emailVerified', ['image' => 'images/failed.png', 'msg' => 'The Link has expired', 'status' => 0]);   
            }else{
                if(empty($user)) {
                    throw new Exception("Not a valid user");
                }
    
                
                $user->email_key = '';
                $user->status = $user->email_confirm = 1;
                $user->email_verified_at = now();
                $user->save();
    
    
                PlanUserAssoc::assocUserWithOrder(1, $user->id); //associate free plan with user
                
                DB::commit();
                return view('emailVerified', ['image' => 'images/success.png', 'msg' => 'Email verified', 'status' => 1]);     
            }
        } catch (\Exception $e) {
            DB::rollback();
            return view('emailVerified', ['image' => 'images/failed.png', 'msg' => 'Email verification failed', 'status' => 0]);        
        }
    }

    /**
     *
     * @return type
     */
    public function doLogout(Request $request) {
        try {
            if ($request->header('Authorization') != "") {
                JWTAuth::invalidate(JWTAuth::getToken());
//                JWTAuth::invalidate($request->header('Authorization'));
                auth()->logout();
            }
            auth()->logout(true);
        } catch (\Exception $exc) {
            return response()->json(['data' => 'Logged out Successfully', 'code' => 1]);
        }

        return response()->json(['data' => 'Logged out Successfully', 'code' => 1]);
    }

    /**
     *
     * @param Request $request
     */
    public function doForgotPassword(Request $request) {
        if (!isset($request->email) || $request->email == "") {
            return response()->json(['data' => 'Please enter Email', 'code' => 0]);
        }
        if (!CustomFunction::validate_input($request->email, 'email')) {
            return response()->json(['data' => 'Please enter valid Email', 'code' => 0]);
        }

        $email = CustomFunction::filter_input($request->email);
        $is_exists = User::getUserDetails($email, 'email');
        if (empty($is_exists)) {
            return response()->json(['data' => 'No Details found for this Email', 'code' => 0]);
        }
        $full_name = $is_exists[0]['full_name'];
        $urole = $is_exists[0]['urole'];

        if ($urole == admin_role) {
            return response()->json(['data' => 'No Details found for this Email', 'code' => 0]);
        }

        $random_no = CustomFunction::random_string(20);
        $confirm_url = url('resetpassword/' . $random_no);
        $update_user = User::where('email', $email)->first();
        $update_user->password_key = $random_no;
        if ($update_user->save()) {
            try {
                $site_data = GeneralSetting::getAllDetails();
                $logo = file_path . '/' . $site_data['header_logo'];

                $emaildata = array(
                    'name' => $full_name,
                    'logo_img' => $logo,
                    'site_name' => $site_data['site_title'],
                    'confirm_url' => $confirm_url
                );

//                Mail::send('emails.forgotpassword', $emaildata,
//                    function ($message) use ($email, $full_name) {
//                        $message->to($email, $full_name)->subject
//                        ('Reset Password Request');
//                    });

                Mail::to($email)->send(
                        new SendgridMail(
                        'emails.forgotpassword', $email, [], 'Reset Password Request', [
                    'name' => $full_name,
                    'logo_img' => $logo,
                    'confirm_url' => $confirm_url,
                        ]
                        )
                );


                return response()->json([
                            'data' => 'Password Reset link is sent to your Email address. Note: If you don\'t see the email in your inbox, then please check your SPAM folder too.',
                            'code' => 1
                ]);
            } catch (\Exception $ex) {
                // dd($ex->getMessage());
                $error_msg = $ex->getMessage();

                return response()->json(['data' => 'Details not sent, please try again', 'code' => 0]);
            }
        }

        return response()->json(['data' => 'Details not sent, please try again', 'code' => 0]);
    }

    /**
     *
     * @param Request $request
     */
    public function checkForgotPassword(Request $request) {
        if (!isset($request->id) || $request->id == "") {
            return response()->json(['data' => 'Invalid Request, please try again', 'code' => 0]);
        }

        $password_key = CustomFunction::filter_input($request->id);
        $is_exists = User::getUserDetails($password_key, 'password_key');
        if (empty($is_exists)) {
            return response()->json(['data' => 'Invalid Request, please try again', 'code' => 0]);
        }

        $full_name = $is_exists[0]['full_name'];

        return response()->json(['data' => $full_name, 'code' => 1]);
    }

    public function updateForgotPassword(Request $request) {
        if (!isset($request->id) || $request->id == "") {
            return response()->json(['data' => 'Invalid Request, please try again', 'code' => 0]);
        }
        if (!isset($request->password) || $request->password == "") {
            return response()->json(['data' => 'Invalid Request, please try again', 'code' => 0]);
        }
        if (strlen($request->password) < 6) {
            return response()->json(['data' => 'Min. Password length must be 6 characters', 'code' => 0]);
        }

        $password_key = CustomFunction::filter_input($request->id);
        $password = CustomFunction::filter_input($request->password);
        $password_hash = Hash::make($password);

        $is_exists = User::getUserDetails($password_key, 'password_key');
        if (empty($is_exists)) {
            return response()->json(['data' => 'No details found for this user, please try again', 'code' => 0]);
        }

        $update_user = User::where('password_key', $password_key)->first();
        $update_user->password = $password_hash;
        $update_user->password_key = "";
        $update_user->updated_at = Carbon::now(config('app.timezone'));

        if ($update_user->save()) {
            return response()->json(['data' => 'Password updated successfully, you may login now', 'code' => 1]);
        } else {
            return response()->json(['data' => 'Password not update, please try again', 'code' => 0]);
        }
    }

    public function getUserDetails() {
        $res = auth()->user();
        $id = $res->id;

        return response()->json(['data' => $id]);
    }

    public function getProfile(Request $request, $user_id){
        $page   = (int) $request->page ?? 1;
        $limit  = 4;
        $start  = $limit * ($page - 1);
        $userProfileData = User::where('id',$user_id)->first();
        if(!empty($userProfileData)){
            // Get product reviews data
            // $reviewsData = Product::with(['reviews' => function($q) use($userProfileData) {
            //     $q->where('user_id', '!=', $userProfileData->id);
            // }])->where('user_id',$userProfileData->id)->get();

            $userProductDatas = Product::with('ProductImages')->where('user_id',$userProfileData->id)->get();
            if(count($userProductDatas) > 0){
                $reviewBlankArr = [];
                foreach ($userProductDatas as $key => $userProductData) {
                    $reviewDatas = ProductReviews::with('user')->where([['product_id','=',$userProductData->id],['user_id','!=',$userProfileData->id]])->orderBy('id', 'DESC')->get();
                    if(!empty($reviewDatas) && count($reviewDatas) > 0){
                        foreach ($reviewDatas as $revKey => $reviewData) {
                            $reviewBlankArr[] = [
                                'id'            => $reviewData->id,
                                'ratings'       => $reviewData->ratings,
                                'description'   => $reviewData->description,
                                'product_name'  => $userProductData->name,
                                'product_image' => @$userProductData->ProductImages[0]->image_name,
                                'user_id'       => $reviewData->user->id,
                                'user_name'     => $reviewData->user->full_name,
                                'user_image'    => $reviewData->user->profile_photo
                            ];
                        }
                    }
                }
                if(!empty($reviewBlankArr) && count($reviewBlankArr) > 0){
                    $mostRecentComments = array_slice(array_values(collect($reviewBlankArr)->sortBy('id')->reverse()->toArray()),0,5);
                }
            }

            // if(!empty($reviewsData) && count($reviewsData) > 0){
            //     $rating5Star = $rating4Star = $rating3Star = $rating2Star = $rating1Star = $avgRating = 0;
            //     foreach ($reviewsData as $reviewKey => $review) {
            //         if(!empty($review->reviews) && count($review->reviews) > 0){
            //             foreach ($review->reviews as $rKey => $reviewData) {
            //                 if($reviewData->ratings == 5)
            //                     $rating5Star++;
            //                 else if($reviewData->ratings == 4)
            //                     $rating4Star++;
            //                 else if($reviewData->ratings == 3)
            //                     $rating3Star++;
            //                 else if($reviewData->ratings == 2)
            //                     $rating2Star++;
            //                 else if($reviewData->ratings == 1)
            //                     $rating1Star++;
            //             }

            //             $avgRating = $this->calcAverageRating(['5' => $rating5Star, '4' => $rating4Star, '3' => $rating3Star, '2' => $rating2Star, '1' => $rating1Star]);
            //             $totalReviews = $rating5Star + $rating4Star + $rating3Star + $rating2Star + $rating1Star;
        
            //             $reviewPer5Star = ($rating5Star * 100) / $totalReviews;
            //             $reviewPer4Star = ($rating4Star * 100) / $totalReviews;
            //             $reviewPer3Star = ($rating3Star * 100) / $totalReviews;
            //             $reviewPer2Star = ($rating2Star * 100) / $totalReviews;
            //             $reviewPer1Star = ($rating1Star * 100) / $totalReviews;
            //         }
            //     }
            // }


            // Get user categories and skill data start here
            $categories = DB::table('user_category')
                ->join('category', 'category.id', '=', 'user_category.category_id')
                ->select('user_category.*', 'category.title')
                ->where('user_category.user_id', $userProfileData->id)
                ->get();

            foreach ($categories as $k => $category) {
                $skill = DB::table('user_category_skill')
                        ->join('tag', 'tag.id', '=', 'user_category_skill.skill_id')
                        ->select('user_category_skill.*', 'tag.title', 'tag.title as text')
                        ->where('user_category_skill.user_id', $userProfileData->id)
                        ->where('user_category_skill.category_id', $category->category_id)
                        ->get();
                $categories[$k]->skills = $skill;
            }
            // Get user categories and skill data end here

            // Get user project data start here
            $totalproject   = Project::where('user_id',$userProfileData->id)->count();
            $totalPages     = ceil($totalproject / $limit);

            $query = Project::where('user_id', $userProfileData->id)->with(['category', 'reviews'])
                            ->with('ProjectImage', function($query) {
                                $query->where('project_image.type', '=', 'image');
                            });
                    
            $query = $query->orderBy('project.created_at', 'desc')->offset($start)->limit($limit)->get();
            
            $projectData = $this->getProjectdata($query, $userProfileData->id);
            // Get user project data end here

            // Get user community data start here
            $communityLimit = 3;
            $logged_user_id = $userProfileData->id;
            $communityPage  = (int) $request->communityPage ?? 1;
            $communityStart = $communityLimit * ($communityPage - 1);

            $totalCommunities       = Community::getByStatus(true)->where('user_id',$userProfileData->id)->count();
            $totalCommunityPages    = ceil($totalCommunities / $communityLimit);

            $communities = Community
                            ::getByStatus(true)
                            ->where('user_id',$userProfileData->id)
                            ->withCount('UserCommunityVote')
                            ->withCount('UserCommunityViewed')
                            ->withCount('CommunityAnswer')
                            ->with('CommunityTagTagged.Tag')
                            ->with('user')
                            ->offset($communityStart)->limit($communityLimit)
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
            // Get user community data end here
            
            return response()->json([
                'success'               => true, 
                'userProfileData'       => !empty($userProfileData) ? $userProfileData : [],
                'projectData'           => !empty($projectData) ? $projectData : [],
                'categories'            => !empty($categories) ? $categories : [],
                'page'                  => $page,
                'totalPages'            => @$totalPages ? $totalPages : 0,
                'communityData'         => !empty($communities) ? $communities : [],
                'communityPage'         => @$communityPage ? $communityPage : 1,
                'totalCommunityPages'   => @$totalCommunityPages ? $totalCommunityPages : 0,
                // 'totalReviews'          => @$totalReviews ? $totalReviews : 0,
                // 'avgRating'             => @$avgRating ? floor($avgRating) : 0,
                // 'reviewPer5Star'        => @$reviewPer5Star ? $reviewPer5Star : 0,
                // 'reviewPer4Star'        => @$reviewPer4Star ? $reviewPer4Star : 0,
                // 'reviewPer3Star'        => @$reviewPer3Star ? $reviewPer3Star : 0,
                // 'reviewPer2Star'        => @$reviewPer2Star ? $reviewPer2Star : 0,
                // 'reviewPer1Star'        => @$reviewPer1Star ? $reviewPer1Star : 0,
                'mostRecentComments'    => @$mostRecentComments ? $mostRecentComments : [],
            ]);
        }
    }

    // private function calcAverageRating($ratings) {

    //     $totalWeight    = 0;
    //     $totalReviews   = 0;
        
    //     foreach ($ratings as $weight => $numberofReviews) {
    //         $WeightMultipliedByNumber = $weight * $numberofReviews;
    //         $totalWeight += $WeightMultipliedByNumber;
    //         $totalReviews += $numberofReviews;
    //     }
        
    //     //divide the total weight by total number of reviews
    //     $averageRating = $totalWeight / $totalReviews;
        
    //     return $averageRating;
    // }

    private function getProjectdata($query, $logged_user_id = 0)
    {
        return $query->map(function ($projectItem) use ($logged_user_id) {
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

                        return $projectItem;
                    })
                    ->toArray();
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->createNewToken(JWTAuth::parseToken()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token) {
        return response()->json([
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    'user' => auth()->user()
        ]);
    }



function IPtoLocation($ip){
    $api_key =  config('app.apikey');
    $apiURL = 'https://freegeoip.app/json/'.$ip.'?'.$api_key;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiURL);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    curl_close($ch);
    $ipData = json_decode($response);
    return $ipData;
}
}
