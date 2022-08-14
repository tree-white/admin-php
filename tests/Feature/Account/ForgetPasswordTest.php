<?php

namespace Tests\Feature\Account;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ForgetPasswordTest extends TestCase
{
    use RefreshDatabase;
    /**
     * 验证表单
     * @test
     */
    public function validateForm()
    {
        // 找回密码需要有：账号(account) 验证码(code) 新密码(password) 确认新密码(password_confirmation)
        $response = $this->post('/api/account/forget-password', []);

        $response->assertSessionHasErrors(['account', 'password']);
    }

    /**
     * 账号不存在
     * @test
     */
    public function accountDoesNotExist()
    {
        $user = make(User::class);
        $response = $this->post('/api/account/forget-password', [
            'account' => $user->email
        ]);

        $response->assertSessionHasErrors(['account']);
    }

    /**
     * 找回密码
     * @test
     */
    public function retrievePassword()
    {
        $user = create(User::class);
        $response = $this->postJson('/api/account/forget-password', [
            'account' => $user->email,
            'password' => 'admin666',
            'password_confirmation' => 'admin666',
        ]);

        $response->assertOk();
    }
}
