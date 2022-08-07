<?php

namespace Tests\Feature\ValidateCode;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SendValidateCodeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 发送邮件验证码
     * @test
     */
    public function emailVerificationCode()
    {
        $user = User::factory()->make();
        $this->post('/api/code/send', [
            'account' => $user->email
        ])->assertOk();
    }

    /**
     * 发送手机验证码
     */
    public function sendMobilePhoneVerificationCode()
    {
        $this->post('/api/code/send', [
            'account' => '15820153724'
        ])->assertOk();
    }

    /**
     * 邮箱格式错误
     * @test
     */
    public function emailFormatError()
    {
        $this->post('/api/code/send', [
            'account' => 'tw'
        ])->assertSessionHasErrors('account');
    }

    /**
     * 重复发送验证码
     * @test
     */
    public function repeatSendVerificationCode()
    {
        config(['app.debug' => false]);
        $user = User::factory()->make();
        $this->post('/api/code/send', ['account' => $user->email])->assertOk();
        $this->post('/api/code/send', ['account' => $user->email])->assertStatus(403);
    }
}
