<?php

use App\Http\Controllers\ConfigController;
use App\Http\Controllers\ForgetPasswordController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RoleController;
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

Route::post('code/send', [ValidateCodeController::class, 'send']);
Route::post('code/user/{type}', [ValidateCodeController::class, 'user']);

Route::put('config/{name}', [ConfigController::class, 'update']);

Route::post('upload/avatar', [UploadController::class, 'avatar']);

/**
 * 权限接口需要包含增伤该车，可以使用Laravel提供的方法
 * 默认情况下单条查询时会自动按「id」查询，如果想要更改为其他查询方式，需要使用「scoped」
 * |- 例如：->scoped(['permission' => 'name'])
 */
Route::apiResource('permission', PermissionController::class);

Route::apiResource('role', RoleController::class);
