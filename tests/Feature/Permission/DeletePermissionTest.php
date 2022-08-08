<?php

namespace Tests\Feature\Permission;

use App\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class DeletePermissionTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->signIn();
    }

    // /**
    //  * 删除权限的ID不能为空
    //  * @test
    //  */
    // public function removePermissionsIdCantBeEmpty()
    // {
    //     $permission = create(Permission::class);
    //     $response = $this->delete("/api/permission/{$permission['id']}");

    //     $response->assertStatus(200);
    // }

    /**
     * 删除权限
     * @test
     */
    public function removePermission()
    {
        $permission = create(Permission::class);
        $response = $this->delete("/api/permission/{$permission['id']}");

        $response->assertOk()->assertJson(fn (AssertableJson $json) => $json->has('message')->etc());
    }
}
