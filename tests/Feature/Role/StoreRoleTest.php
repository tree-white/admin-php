<?php

namespace Tests\Feature\Role;

use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreRoleTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();
        $this->signIn();
    }

    /**
     * 添加角色字段不能为空
     * @test
     */
    public function addTheRoleFieldCannotBeEmpty()
    {
        $response = $this->postJson('/api/role');

        $response->assertStatus(422)->assertJsonValidationErrors(['name', 'title']);
    }

    /**
     * 添加角色字段不能重复
     * @test
     */
    public function addTheRoleFieldCannotBeRepeated()
    {
        $role = create(Role::class);
        $response = $this->postJson('/api/role', [
            'name' => $role->name,
            'title' => $role->title
        ]);

        $response->assertStatus(422)->assertJsonValidationErrors(['name', 'title']);
    }

    /**
     * 成功添加角色
     * @test
     */
    public function successfullyAddingRole()
    {
        $response = $this->postJson('/api/role', [
            'name' => 'admin',
            'title' => '超级管理员'
        ]);

        $response->assertSuccessful()->assertJson(['data' => []]);
    }
}
