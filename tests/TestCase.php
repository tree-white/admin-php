<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $user;

    // 测试时使用数据填充一下两种方式都可以
    // protected $seed = true;
    // ↑等同于↓
    // protected function setUp(): void
    // {
    //     parent::setUp();
    //     // $this->seed();
    // }

    protected function signIn(User $user = null)
    {
        $user = $user ?? create(User::class);
        $this->actingAs($user);
        $this->user = $user;
        return $this;
    }
}
