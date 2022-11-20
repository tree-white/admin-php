<?php

namespace App\Services;

use App\Models\Permission;
use App\Models\Site;

class PermissionService
{
    protected $site;
    protected $permissions = [];

    function syncSiteModulePermission(Site $site)
    {
        $this->site = $site;
        $site->modules->each(function ($module) {
            $permissionFile = base_path("addons/{$module['name']}/Config/permissions.php");

            if (is_file($permissionFile)) {
                collect(require $permissionFile)->each(function ($permission) use ($module) {
                    $this->syncPermission($permission['items'] ?? [], $module);
                });
            }
        });

        // 删除不存在的权限表
        $site->permissions()->whereNotIn('name', $this->permissions)->delete();
    }

    protected function syncPermission($permissions, $module)
    {
        collect($permissions)->each(function ($item) use ($module) {
            $name = $module['name'] . '-' . $item['name'];
            $data = [
                'name' => $name,
                'title' => $item['title'],
                'site_id' => $this->site->id,
                'module_id' => $module['id']
            ];
            Permission::updateOrCreate($data);

            $this->permissions[] = $name;
        });
    }
}
