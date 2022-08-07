<?php

namespace Tests\Feature\Role;

use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class UpdateRoleTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();
        $this->signIn();
    }

    /**
     * 字段不能为空
     * @test
     */
    public function updateRoleFieldCannotBeEmpty()
    {
        $role = create(Role::class);
        $response = $this->putJson("/api/role/{$role['id']}");

        $response->assertStatus(422)->assertJsonValidationErrors(['name', 'title']);
    }

    /**
     * 更新权限字段不能重复
     * @test
     */
    public function updateRolesFieldCantBeRepeated()
    {
        $role1 = create(Role::class);
        $role2 = create(Role::class);
        $response = $this->putJson("/api/role/{$role2['id']}", [
            'name' => $role1['name'],
            'title' => $role1['title']
        ]);
        $response->assertStatus(422)->assertJsonValidationErrors(['name', 'title']);
    }

    /**
     * 更新权限记录
     * @test
     */
    public function updateRoleAccessRecords()
    {
        $role = create(Role::class);
        $response = $this->putJson("/api/role/{$role['id']}", [
            'name' => $this->faker()->word(),
            'title' => $this->faker()->word()
        ]);

        $response->assertOk()->assertJson(fn (AssertableJson $json) => $json->has('data'));
    }
}
