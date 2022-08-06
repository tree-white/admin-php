<?php

namespace Tests\Feature\Config;

use App\Models\Config;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ConfigTest extends TestCase
{
    use RefreshDatabase;
    /**
     * 更新网站配置
     * @test
     */
    public function updateSiteConfiguration()
    {
        $this->signIn();
        $response = $this->put('/api/config/site', [
            'name' => '木白',
            'tel' => '15820153724',
        ]);

        $response->assertSee('15820153724');
    }
}
