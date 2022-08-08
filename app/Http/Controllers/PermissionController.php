<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Http\Resources\PermissionResource;
use App\Models\Permission;

class PermissionController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
    }

    /**
     * 显示资源列表.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 如果需要获取所有则需要通过静态方法「collection」来获取
        $permission = Permission::all();
        return $this->success('获取成功', PermissionResource::collection($permission));
    }

    /**
     * 将新创建的资源存储在存储中.
     * @param  \App\Http\Requests\StorePermissionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePermissionRequest $request)
    {
        $permission = Permission::create(['name' => $request->name, 'title' => $request->title]);
        return $this->success('创建成功', new PermissionResource($permission));
    }

    /**
     * 显示指定的资源.
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        // 如果只要指定单条的话只要 new 一下实例传入即可
        return $this->success('获取成功', new PermissionResource($permission));
    }

    /**
     * 更新指定的资源存储.
     * @param  \App\Http\Requests\UpdatePermissionRequest  $request
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        $permission->name = $request->name;
        $permission->title = $request->title;
        $permission->save();
        return $this->success('更新成功', new PermissionResource($permission));
    }

    /**
     * 从存储删除指定的资源
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
        return $this->success('权限删除成功');
    }
}
