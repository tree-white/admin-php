<?php

use App\Http\Controllers\SystemController;
use App\Http\Controllers\FansController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\ForgetPasswordController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CodeController;
use App\Http\Controllers\InitController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\SiteModuleController;
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
Route::post('code/send', [CodeController::class, 'send']);
// 给当前用户发送验证码
Route::post('code/user/{type}', [CodeController::class, 'user']);
// 给不存在用户发验证码
Route::post('code/not_exist_user', [CodeController::class, 'notExistUser']);
// 给存在用户发验证码
Route::post('code/exist_user', [CodeController::class, 'existUser']);

// 初始化配置
Route::get('init', InitController::class);
// 更改配置项
Route::put('system', [SystemController::class, 'update']);
// 获取配置项
Route::get('system', [SystemController::class, 'get']);

// 上传头像
Route::post('upload/avatar', [UploadController::class, 'avatar']);
// 上传头像
Route::post('upload/image', [UploadController::class, 'image']);

/**
 * 权限接口需要包含增伤该车，可以使用Laravel提供的方法
 * 默认情况下单条查询时会自动按「id」查询，如果想要更改为其他查询方式，需要使用「scoped」
 * |- 例如：->scoped(['permission' => 'name'])
 */
Route::apiResource('permission', PermissionController::class);

// 角色管理
Route::put('role/permission/{role}', [RoleController::class, 'permission']);
Route::apiResource('site.role', RoleController::class);

Route::get('user/info', [UserController::class, 'info']);
Route::apiResource('user', UserController::class);

/** 关注管理 */
Route::get('follower/{user}', [FollowerController::class, 'index']);
Route::get('follower/toggle/{user}', [FollowerController::class, 'toggle']);

/** 粉丝管理 */
Route::get('fans/{user}', [FansController::class, 'index']);

/** 站点管理 */
Route::apiResource('site', SiteController::class);
/** 站点管理员 */
Route::apiResource('site.admin', AdminController::class);
/** 模块化 */
Route::get('module/syncLocalModule', [ModuleController::class, 'syncLocalModule']);
Route::apiResource('module', ModuleController::class);

/** 站点模块 */
Route::apiResource('site.module', SiteModuleController::class);
Route::get('site_default_module/site/{site}/module/{module}', [SiteModuleController::class, 'setSiteDefaultModule']);
Route::get('sync_site_module/site/{site}', [SiteModuleController::class, 'syncSiteModule']);
