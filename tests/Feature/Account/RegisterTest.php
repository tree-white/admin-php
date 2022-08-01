<?php

namespace Tests\Feature\Account;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase; // 测试自动初始化数据库

    protected function data()
    {
        $user = User::factory()->make();
        return [
            'account' => $user->email,
            'password' => 'admin888',
            'password_confirmation' => 'admin888',
            'code' => app('code')->email($user->email)
        ];
    }

    /**
     * 用户注册
     * @test
     */
    public function userRegister()
    {
        $response = $this->post('/api/register', $this->data());
        $response->assertOk();
    }

    /**
     * 验证码错误
     * @test
     */
    public function verificationCodeError()
    {
        $data = $this->data();
        $data['code'] = 'abcd';
        $response = $this->post('/api/register', $data);
        $response->assertSessionHasErrors('code');
    }

    /**
     * 非法邮箱验证
     * @test
     */
    public function registerAccountValidate()
    {
        $response = $this->post('/api/register', ['account' => 'tw'] + $this->data());
        $response->assertSessionHasErrors('account');
    }

    /**
     * 邮箱必填验证
     * @test
     */
    public function AccountRequiredValidate()
    {
        $data = $this->data();
        unset($data['account']);
        $response = $this->post('/api/register', $data);
        $response->assertSessionHasErrors('account');
    }

    /**
     * 邮箱唯一性
     * @test
     */
    public function AccountUniqueValidate()
    {
        $data = $this->data();
        $response1 = $this->post('/api/register', $data);
        $response2 = $this->post('/api/register', $data);
        $response2->assertSessionHasErrors('account');
    }

    /**
     * 确认密码验证错误
     * @test
     */
    public function confirmationPasswordValidateWrong()
    {
        // $data = $this->data();
        // $data['password_confirmation'] = 'admin';
        // $response = $this->post('/api/register', $data);
        // $response->assertSessionHasErrors('password');
        /* 等同于一下写法 ↓ */
        $this->post('/api/register', ['password' => 'abcde'] + $this->data())->assertSessionHasErrors('password');
    }
}
