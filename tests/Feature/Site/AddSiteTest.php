<?php

namespace Tests\Feature\Site;

use App\Models\Site;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddSiteTest extends TestCase
{

    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->signIn();
    }

    /**
     * 表单验证
     * @test
     */
    public function formValidation()
    {
        $response = $this->postJson('/api/site', ['url' => '1212', 'email' => 'asdf']);
        $response->assertJsonValidationErrors(['title', 'url', 'email']);
    }

    /**
     * 网站名称不能重复
     * @test
     */
    public function webSiteNameCannotBeRepeated()
    {
        $site = create(Site::class, null, ['user_id' => $this->user->id]);

        $response = $this->postJson('/api/site', ['title' => $site->title]);

        $response->assertJsonValidationErrors(['title']);
    }

    /**
     * 成功新增站点
     * @test
     */
    public function successInTheNewSite()
    {

        $response = $this->postJson('/api/site', ['title' => $this->faker()->sentence(3)]);
        $response->assertSuccessful()->assertJson(['message' => '站点添加成功']);
    }
}
