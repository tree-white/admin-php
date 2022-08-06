<?php

namespace Tests\Feature\ValidateCode;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GuestValidateCodeTest extends TestCase
{
    /**
     * 发送邮件验证码
     * @test
     */
    public function emailVerificationCode()
    {
        $user = User::factory()->make();
        $this->post('/api/code/guest', [
            'account' => $user->email
        ])->assertOk();
    }

    /**
     * 发送手机验证码
     * @test
     */
    public function sendMobilePhoneVerificationCode()
    {
        $this->withoutExceptionHandling();
        $this->post('/api/code/guest', [
            'account' => '15820153724'
        ])->assertOk();
    }

    /**
     * 邮箱格式错误
     * @test
     */
    public function emailFormatError()
    {
        $this->post('/api/code/guest', [
            'account' => 'tw'
        ])->assertSessionHasErrors('account');
    }

    /**
     * 重复发送验证码
     * @test
     */
    public function repeatSendVerificationCode()
    {
        $user = User::factory()->make();
        $this->post('/api/code/guest', [
            'account' => $user->email
        ])->assertOk();
        $this->post('/api/code/guest', [
            'account' => $user->email
        ])->assertStatus(403);
    }
}
