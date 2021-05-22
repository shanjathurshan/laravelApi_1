<?php

use App\Http\Controllers\DeviceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("login",[UserController::class,'index']);
Route::post("signup",[UserController::class,'signup']);
Route::put("updateUser",[UserController::class,'updateUser']);
Route::delete("deleteUser/{id}",[UserController::class,'deleteUser']);

Route::get('list',[DeviceController::class,'list']);
Route::post('add',[DeviceController::class,'add']);
Route::post('test',[DeviceController::class,'test']);
Route::put('testup',[DeviceController::class,'testup']);
Route::get('testse/{name}',[DeviceController::class,'testse']);