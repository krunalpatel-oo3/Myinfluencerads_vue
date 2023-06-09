<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Exception;
use Validator;
use App\Models\User;
use DataTables;
class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        echo 'Test index.';
    }

    function login(Request $request){
        if(Auth::attempt(['email'=> $request->email, 'password' => $request->password])){
            echo 'TES...';
        }
        dd($request->all());
        echo 'Login....';
    }

    public function register(){
        $validator = Validator::make($request->all(),[
            'name' => 'requied',
            'email' => 'requied|email',
            'password' => 'requied',
            'c_password' => 'requied|same:password',
        ]);
        if($validator->fails()){
            $response = [
                'status' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 400);
        }

        $input =  $request->all();
        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);

        $success['token'] = $user->createToken('MyApp')->plainTextToken;
        $success['name'] = $user->name;
        $response = [
            'success' => true,
            'data' => $success,
            'message' => 'User registered successfully.'
        ];
    }

    public function login_process(Request $request){
        $result = User::where(['mobile' => $request->mobile])->first();
        if($result){
            $user = Auth::loginUsingId($result->id);
            $success['token'] = $user->createToken('MyApp')->plainTextToken;
            $success['name'] = $user->name;
            $response = [
                'success' => true,
                'data' => $success,
                'message' => 'User registered successfully.'
            ];
        }else{
            $response = [
                'success' => false,
                'message' => 'Unauthorised.'
            ];
        }
        return response()->json($response, 200);

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->plainTextToken;
            $success['name'] = $user->name;
            $response = [
                'success' => true,
                'data' => $success,
                'message' => 'User registered successfully.'
            ];
            return response()->json($response, 200);
        }else{
            $response = [
                'success' => false,
                'message' => 'Unauthorised.'
            ];
            return response()->json($response, 200);
        }
    }

    function doRegister(Request $request){
        try{
            DB::beginTransaction();
            $fname = $request->fname;
            $lname = $request->lname;
            $email = $request->email;
            $role = $request->role;
            $phone_number = $request->phone_number;
            $password = $request->password;
            $confirm_password = $request->confirm_pass;
            
            if(strlen($password) < 8) {
                throw new Exception('Password length must be atleast 8 characters');
            }


        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage(), 'code' => 0]);
        }
        dd($request->all());
        echo 'Login....';
    }

    public function userInfo(Request $request){
        $uid = Auth::user()->id;
        if(!empty($uid)){
            $response['status'] = true;
            $response['data'] = Auth::user();
            return $response;
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function userDetails(Request $request){

        if ($request->ajax()) {
            $data = User::get();
            return DataTables::of($data)
            ->make(true);
        }else{
            echo 'This ';
            die;
        }
        // dd($request->all());
        // // $users = User::select('id','name', 'email', 'mobile')->first();
        // $users = User::latest()->get();
        // // return  response()->json(['user' => $users]);
        // return Datatables::of($users)
        //         ->addIndexColumn()
        //         ->addColumn('action', function($row){
        //             $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
        //             return $actionBtn;
        //         })
        //         ->rawColumns(['action'])
        //         ->make(true);

        // // return  response()->json($users);
        $users = User::select('id', 'name', 'mobile');

        return datatables($users)->make(true);
    }
    public function resendOtp(Request $request){
        // DB::table('login_status')->where('')
        
        // dd($request->all());
    }
    
    public function userRoles(){
        $roles = DB::table('user_roles')->get();
        return $roles;
        // dd($roles);
    }

    public function logout(){
        $user = Auth::user();
        // dd($user);
        // $user->currentAccessToken()->delete();
        if(method_exists(auth()->user()->currentAccessToken(), 'delete')) {
            auth()->user()->currentAccessToken()->delete();
        }
        
        auth()->guard('web')->logout();

        $response['status'] = true;
        $response['message'] = 'User Logout successfully.';
        return $response;
    }
}
