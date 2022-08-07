<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\EmailValidateCodeNotification;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Notification;

class CodeService
{

    /**
     * 统一发送验证码
     */
    public function send(string|int $account)
    {
        $action = filter_var($account, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile';
        // 本地开发不开启时间限制
        if (!app()->isLocal() && Cache::get($account)) {
            abort('403', '验证码获取频繁，请' . config('tw.code_expire_time') . 's后再试');
        }
        return $this->$action($account);
    }

    /**
     * 邮箱验证码
     */
    public function email(string $email): int
    {
        $code = $this->generateVerificationCode();
        $user = User::factory()->make(['email' => $email]);
        Notification::send($user, new EmailValidateCodeNotification($code));
        Cache::put($email, $code, config('tw.code_expire_time'));
        return $code;
    }

    /**
     * 手机号验证码
     */
    protected function mobile($phone)
    {
        $code = $this->generateVerificationCode();
        app('sms')->send($phone, 'SMS_154950909', ['code' => $code]);
        return $code;
    }

    /**
     * 生成验证码
     */
    protected function generateVerificationCode(): int
    {
        return mt_rand(1000, 9999);
    }

    /**
     * 校验验证码
     */
    public function check($account, $code): bool
    {
        return Cache::get($account) == $code;
    }

    /**
     * 清除验证码
     */
    public function clear(string|int $account): void
    {
        Cache::forget($account);
    }
}
