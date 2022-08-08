<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
    }

    /**
     * 显示资源的清单
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 如果需要获取所有则需要通过静态方法「collection」来获取
        $role = Role::all();
        return RoleResource::collection($role);
    }

    /**
     * 一个新创建的资源存储在存储
     * @param  \App\Http\Requests\StoreRoleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoleRequest $request, Role $role)
    {
        $role->name = $request->name;
        $role->title = $request->title;
        $role->save();
        return new RoleResource($role);
    }

    /**
     * 显示指定的资源
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        // 如果只要指定单条的话只要 new 一下实例传入即可
        return new RoleResource($role);
    }

    /**
     * 更新指定的资源存储
     * @param  \App\Http\Requests\UpdateRoleRequest  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->name = $request->name;
        $role->title = $request->title;
        $role->save();
        return new RoleResource($role);
    }

    /**
     * 从存储删除指定的资源
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return response(['message' => '角色删除成功']);
    }

    /**
     * 给角色分配权限
     */
    public function permission(Role $role, Request $request)
    {
        $permissions = $request->permission;
        $role->syncPermissions($permissions);
        return $this->success('权限分配成功');
    }
}
