<?php

use App\Http\Controllers\ConfigController;
use App\Http\Controllers\FansController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\ForgetPasswordController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\UserController;
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

// 注册
Route::post('register', RegisterController::class);
// 登录
Route::post('login', LoginController::class);
// 忘记密码
Route::post('account/forget-password', ForgetPasswordController::class);
// 发送验证码
Route::post('code/send', [ValidateCodeController::class, 'send']);
// 给当前用户发送验证码
Route::post('code/user/{type}', [ValidateCodeController::class, 'user']);
// 给未注册用户发验证码
Route::post('code/not_exist_user', [ValidateCodeController::class, 'notExistUser']);
// 更改配置项
Route::put('config/{name}', [ConfigController::class, 'update']);
// 上传头像
Route::post('upload/avatar', [UploadController::class, 'avatar']);

/**
 * 权限接口需要包含增伤该车，可以使用Laravel提供的方法
 * 默认情况下单条查询时会自动按「id」查询，如果想要更改为其他查询方式，需要使用「scoped」
 * |- 例如：->scoped(['permission' => 'name'])
 */
Route::apiResource('permission', PermissionController::class);

// 角色管理
Route::put('role/permission/{role}', [RoleController::class, 'permission']);
Route::apiResource('role', RoleController::class);

Route::get('user/info', [UserController::class, 'info']);
Route::apiResource('user', UserController::class);

/** 关注管理 */
Route::get('follower/{user}', [FollowerController::class, 'index']);
Route::get('follower/toggle/{user}', [FollowerController::class, 'toggle']);

/** 粉丝管理 */
Route::get('fans/{user}', [FansController::class, 'index']);
