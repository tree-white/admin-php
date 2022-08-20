<?php

namespace Tests\Feature\Site;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class QuerySiteTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * 获取站点列表
     * @test
     */
    public function querySiteList()
    {
        $this->signIn();
        $response = $this->get('/api/site');

        $response->assertSuccessful()->assertJson(['status' => 'success']);
    }
}
