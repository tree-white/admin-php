<?php

namespace Tests\Feature\Permission;

use App\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class UpdatePermissionTest extends TestCase
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
    public function updatePermissionFieldCannotBeEmpty()
    {
        $permission = create(Permission::class);
        $response = $this->putJson("/api/permission/{$permission['id']}");

        $response->assertStatus(422)->assertJsonValidationErrors(['name', 'title']);
    }

    /**
     * 更新权限字段不能重复
     * @test
     */
    public function updatePermissionsFieldCantBeRepeated()
    {
        $permission1 = create(Permission::class);
        $permission2 = create(Permission::class);
        $response = $this->putJson("/api/permission/{$permission2['id']}", [
            'name' => $permission1['name'],
            'title' => $permission1['title']
        ]);
        $response->assertStatus(422)->assertJsonValidationErrors(['name', 'title']);
    }

    /**
     * 更新权限记录
     * @test
     */
    public function updateAccessRecords()
    {
        $permission = create(Permission::class);
        $response = $this->putJson("/api/permission/{$permission['id']}", [
            'name' => $this->faker()->word(),
            'title' => $this->faker()->word()
        ]);

        $response->assertOk()->assertJson(fn (AssertableJson $json) => $json->has('data'));
    }
}
