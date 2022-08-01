<?php

use App\Models\User;
use App\Notifications\EmailValidateCodeNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('test', function () {
    // return User::factory()->create();
    /* 等同于↓ */
    // $user = User::factory()->make();
    // $user->save();
    // return $user;

    // 邮箱模板
    // return (new EmailValidateCodeNotification())->toMail(User::factory()->make());

    // 通知测试
    Notification::send(User::factory()->make(), new EmailValidateCodeNotification(1232));
});
