<?php

namespace Tests\Feature\Account;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    protected $data = [
        'account' => 'trwite@126.com',
        'password' => 'admin888',
    ];

    /**
     * 登录
     * @test
     */
    public function userLogin()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $response = $this->post('/api/login', ['account' => $user->email, 'password' => 'admin888']);
        $response->assertSee('token');
    }

    /**
     * 错误邮箱登录验证
     * @test
     */
    public function loginAccountRules()
    {
        $response = $this->post('/api/login', ['account' => 'tw', 'password' => 'admin888']);
        $response->assertSessionHasErrors('account');
    }

    /**
     * 邮箱登录必填项验证
     * @test
     */
    public function loginAccountRequired()
    {
        $response = $this->post('/api/login', ['password' => 'admin888']);
        $response->assertSessionHasErrors('account');
    }

    /**
     * 登录密码验证
     * @test
     */
    public function loginPasswordWrong()
    {
        $user = User::factory()->create();
        $response = $this->post('/api/login', ['account' => $user->email, 'password' => 'tw888']);
        $response->assertSessionHasErrors('password');
    }

    /**
     * 邮箱不存在
     * @test
     */
    public function accountUnexist()
    {
        $response = $this->post('/api/login', ['account' => 'treewhite123@yeah.net', 'password' => 'admin888']);
        $response->assertSessionHasErrors('account');
    }

    /**
     * 手机号登录
     * @test
     */
    public function loginByMobile()
    {
        $user = User::factory()->create(['mobile' => '18888888888']);
        $response = $this->post('/api/login', ['account' => $user->mobile, 'password' => 'admin888']);
        $response->assertOk();
    }
}
