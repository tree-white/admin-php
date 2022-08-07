<?php

use App\Http\Controllers\ConfigController;
use App\Http\Controllers\ForgetPasswordController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\ValidateCodeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', RegisterController::class);

Route::post('login', LoginController::class);
Route::post('account/forget-password', ForgetPasswordController::class);

Route::post('code/guest', [ValidateCodeController::class, 'guest']);

Route::put('config/{name}', [ConfigController::class, 'update']);

Route::post('upload/avatar', [UploadController::class, 'avatar']);
