<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class ValidateCodeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 获取邮件验证码
     * @test
     */
    public function getMailVerificationCode()
    {
        $user = User::factory()->make();
        $code = app('code')->email($user->email);
        $this->assertEquals(Cache::get($user->email), $code);
    }
}
