<?php

namespace Tests\Feature\Permission;

use App\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddPermissionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->signIn();
    }

    /**
     * 验证字段不能为空
     * @test
     */
    public function verifyTheFieldCannotBeEmpty()
    {
        $response = $this->postJson('/api/permission', []);

        $response->assertStatus(422)->assertJsonValidationErrors(['name', 'title']);
    }

    /**
     * 字段必须唯一
     * @test
     */
    public function fieldMustBeUnique()
    {
        Permission::create(['name' => 'tw', 'title' => 'tw']);

        $response = $this->postJson('/api/permission', ['name' => 'tw', 'title' => 'tw']);

        $response->assertStatus(422)->assertJsonValidationErrors(['name', 'title']);
    }

    /**
     * 成功添加权限
     * @test
     */
    public function successfullyAddingPermissions()
    {
        $response = $this->postJson('/api/permission', ['name' => 'tw', 'title' => 'tw']);

        $response->assertStatus(201)->assertJsonStructure(['data']);
    }
}
