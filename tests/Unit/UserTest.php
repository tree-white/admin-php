<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 用户默认头像
     * @test
     */
    public function userTheDefaultAvatar()
    {
        $user = create(User::class);
        $this->assertEquals($user->avatar_url, url('images/avatar.jpeg'));
    }

    /**
     * 关注列表
     * @test
     */
    public function userFollower()
    {
        $user = create(User::class);
        $follower = create(User::class);
        $user->followers()->toggle($follower);
        $this->assertEquals($user->followers->first()->id, $follower->id);
    }

    /**
     * 粉丝列表
     * @test
     */
    public function userFans()
    {
        $user1 = create(User::class);
        $user2 = create(User::class);
        $user1->followers()->toggle($user2);
        $this->assertEquals($user2->fans->first()->id, $user1->id);
    }

    /**
     * 是否关注用户
     * @test
     */
    public function userIsFollower()
    {
        $user1 = create(User::class);
        $user2 = create(User::class);
        $user1->followers()->toggle($user2);
        $this->assertTrue($user1->isFollower($user2));
    }
}
