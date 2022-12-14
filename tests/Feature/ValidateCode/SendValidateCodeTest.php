<?php

namespace Tests\Feature\ValidateCode;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
        $user = User::factory()->make();
        $this->post('/api/code/send', ['account' => $user->email])->assertOk();
        $this->post('/api/code/send', ['account' => $user->email])->assertStatus(403);
    }

    /**
     * 给不存在用户发送验证码
     * @test
     */
    public function sendToNotExistUser()
    {
        $user = create(User::class, ['email' => 'trwite@treewhite.com']);
        $response = $this->postJson('/api/code/not_exist_user', ['account' => $user->email]);

        $response->assertJsonValidationErrors('account');
    }

    /**
     * 给存在用户发送验证码
     * @test
     */
    public function sendToExistUser()
    {
        $response = $this->postJson('/api/code/exist_user', ['account' => 'abc@1234.com']);

        $response->assertJsonValidationErrors('account');
    }
}
