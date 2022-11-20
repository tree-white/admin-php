<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use App\Models\Site;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
    }

    public function index(Site $site)
    {
        $roles = $site->roles()->latest()->paginate(10000);
        // 如果需要获取所有则需要通过静态方法「collection」来获取
        return RoleResource::collection($roles);
    }

    /**
     * 一个新创建的资源存储在存储
     * @param  \App\Http\Requests\StoreRoleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoleRequest $request, Site $site, Role $role)
    {
        $role->name = $request->name;
        $role->title = $request->title;
        $site->roles()->save($role);
        return $this->success('角色添加成功');
    }

    /**
     * 显示指定的资源
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Site $site, Role $role)
    {
        // 如果只要指定单条的话只要 new 一下实例传入即可
        return $this->success('获取角色成功', new RoleResource($role));
    }

    /**
     * 更新指定的资源存储
     * @param  \App\Http\Requests\UpdateRoleRequest  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoleRequest $request, Site $site, Role $role)
    {
        $role->fill($request->input())->save();
        return $this->success('编辑角色成功');
    }

    /**
     * 从存储删除指定的资源
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Site $site, Role $role)
    {

        $role->delete();
        return $this->success('角色删除成功');
    }

    /**
     * 给角色分配权限
     */
    public function permission(Role $role, Request $request)
    {
        $permissions = $request->permission;
        $role->syncPermissions($permissions);
        return $this->success('角色权限分配成功');
    }
}
