<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserFollowerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->signIn();
    }

    /**
     * 获取关注列表
     * @test
     */
    public function getFollowerList()
    {
        $user = create(User::class);
        $this->user->followers()->toggle($user);
        $response = $this->getJson('/api/follower/' . $this->user->id)->assertOk();

        $this->assertEquals($this->user->followers()->first()->id, $response['data'][0]['id']);
    }

    /**
     * 关注用户
     * @test
     */
    public function followerUser()
    {
        $user = create(User::class);
        $response = $this->getJson('/api/follower/toggle/' . $user->id)->assertOk();

        $response->assertJson(['data' => true]);
        $this->assertEquals($this->user->followers()->first()->id, $user->id);
    }
}
