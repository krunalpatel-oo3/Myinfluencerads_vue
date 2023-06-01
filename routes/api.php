<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function(){
    Route::post('login','login');
    Route::post('login_process','login_process');
});

Route::post('/registration', [AuthController::class, 'doRegister']);

Route::group(['middleware' => 'auth:sanctum'],function(){
    Route::get('users',[AuthController::class,'userDetails']);
    Route::get('/user-info', [AuthController::class, 'userInfo']);
    Route::post('logout',[AuthController::class,'logout']);
});