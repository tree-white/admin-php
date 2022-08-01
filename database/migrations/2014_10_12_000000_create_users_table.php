<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('unionid')->nullable()->comment('微信开放平台unionid');
            $table->string('openid')->nullable()->comment('微信公众号openid');
            $table->string('miniapp_openid')->nullable()->comment('微信小程序openid');
            $table->string('name')->nullable()->comment('用户名/昵称');
            $table->tinyInteger('sex')->default(1)->comment('性别');
            $table->string('email')->nullable()->unique()->comment('邮箱');
            $table->string('mobile')->nullable()->comment('手机号');
            $table->string('real_name')->nullable()->comment('真实姓名');
            $table->string('password')->nullable()->comment('密码');
            $table->string('home')->nullable()->comment('个人网站');
            $table->string('avatar')->nullable()->comment('头像');
            $table->string('weibo')->nullable()->comment('微博地址');
            $table->string('wechat')->nullable()->comment('微信号');
            $table->string('github')->nullable()->comment('GitHub地址');
            $table->string('qq')->nullable()->comment('QQ号');
            $table->string('wakatime')->nullable()->comment('Wakatime地址');
            $table->timestamp('email_verified_at')->nullable()->comment('邮箱验证时间搓');
            $table->timestamp('mobile_verified_at')->nullable()->comment('手机号验证时间搓');
            $table->rememberToken();
            $table->timestamps();
            $table->unsignedTinyInteger('lock')->nullable()->comment('用户锁定');
            $table->unsignedTinyInteger('status')->nullable()->comment('用户状态');
            $table->unsignedTinyInteger('favour_count')->default(0)->comment('点赞数');
            $table->unsignedTinyInteger('favorite_count')->default(0)->comment('收藏数');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
