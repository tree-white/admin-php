<?php

namespace Tests\Feature\Role;

use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetRoleTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->signIn();
    }

    /**
     * 获取权限列表
     * @test
     */
    public function getRolesList()
    {
        Role::create(['name' => $this->faker()->word(1), 'title' => $this->faker()->title()]);
        $response = $this->get('/api/role');
        $response->assertStatus(200)->assertJson(['data' => []]);
    }

    /**
     * 获取单一权限信息
     * @test
     */
    public function forSingleAccessInformation()
    {
        $role = Role::create(['name' => $this->faker()->word(1), 'title' => $this->faker()->title()]);
        $response = $this->get('/api/role/' . $role->id);
        $response->assertStatus(200)->assertJson(['data' => []]);
    }
}
