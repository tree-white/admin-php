<?php

namespace Tests\Feature\System;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SystemTest extends TestCase
{
    use RefreshDatabase;
    /**
     * 更新网站配置
     * @test
     */
    public function updateSiteSystemuration()
    {
        $this->signIn();
        $response = $this->put('/api/config/site', [
            'name' => '木白',
            'tel' => '15820153724',
        ]);

        $response->assertSee('15820153724');
    }
}
