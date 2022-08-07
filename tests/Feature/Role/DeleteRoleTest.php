<?php

namespace Tests\Feature\Role;

use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class DeleteRoleTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->signIn();
    }


    /**
     * 删除权限
     * @test
     */
    public function removeRole()
    {
        $role = create(Role::class);
        $response = $this->delete("/api/role/{$role['id']}");

        $response->assertOk()->assertJson(fn (AssertableJson $json) => $json->has('message'));
    }
}
