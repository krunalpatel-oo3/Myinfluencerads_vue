<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Exception;

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
        //
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
}
