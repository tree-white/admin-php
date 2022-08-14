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

        // 开启本地开发不限制加上：!app()->isLocal()
        if ($cache = Cache::get($account)) {
            $diff = $cache['sendTime']->diffInSeconds(now());
            if ($diff <= config('system.code.timeout')) {
                abort('403', '获取验证码失败，请 ' .  config('system.code.timeout') - $diff . '秒 后再试');
            }
        }

        $code = $cache ? $cache['code'] : $this->generateCode(); // 生成验证码
        $this->cacheCode($account, $code); // 缓存验证码
        return $this->$action($account, $code);
    }

    /** 邮箱验证码 */
    public function email(string $email, int $code): int
    {
        $user = User::factory()->make(['email' => $email]);
        Notification::send($user, new EmailValidateCodeNotification($code));
        return $code;
    }


    /** 手机号验证码 */
    protected function mobile(string|int $phone, int $code): int
    {
        app('sms')->send($phone, 'SMS_154950909', ['code' => $code]);
        return $code;
    }

    /** 生成验证码 */
    protected function generateCode(): int
    {
        return mt_rand(pow(10, config('system.code.length') - 1), pow(10, config('system.code.length')) - 1);
    }

    /** 缓存验证码 */
    protected function cacheCode(string|int $account, int $code): void
    {
        Cache::put($account, ['code' => $code, 'sendTime' => now()], config('system.code.expire'));
    }

    /** 校验验证码 */
    public function check($account, $code): bool
    {
        if ($cache = Cache::get($account)) {
            return $cache['code'] == $code;
        }
    }

    /** 清除验证码 */
    public function clear(string|int $account): void
    {
        Cache::forget($account);
    }
}
