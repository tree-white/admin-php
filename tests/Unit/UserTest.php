<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * 用户默认头像
     * @test
     */
    public function userTheDefaultAvatar()
    {
        $user = create(User::class);
        $this->assertEquals($user->avatar_url, url('images/avatar.jpeg'));
    }
}
