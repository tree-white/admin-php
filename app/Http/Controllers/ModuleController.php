<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreModuleRequest;
use App\Http\Requests\UpdateModuleRequest;
use App\Http\Resources\ModuleResource;
use App\Models\Module;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class ModuleController extends Controller
{
    public function index()
    {
        $modules = Module::when(request('key'), function ($query, $key) {
            // 模糊搜索
            $query->where($key, 'like', "%" . request('content') . "%");
        })->latest()->paginate(10);
        return ModuleResource::collection($modules);
    }

    public function store(StoreModuleRequest $request)
    {
        $config = $request->input();
        $config['name'] = ucfirst($config['name']);
        // 插件路径
        $addons_path = base_path('addons/' . $config['name']);
        // 设置初始图标
        $preview_path = $config['preview'] ?? public_path('static/preview.png');
        $preview_name = '/preview.' . pathinfo($preview_path, PATHINFO_EXTENSION);
        // 创建模块
        Artisan::call("module:make " . $config['name']);
        // 复制图标
        copy($preview_path, $addons_path . $preview_name);
        $config['preview'] = url('addons/' . $config['name'] . $preview_name);
        // 修改config内容
        file_put_contents(
            $addons_path . '/Config/config.php',
            "<?php return " . var_export($config, true) . ";"
        );

        return $this->success('新增模块成功');
    }

    public function destroy(Module $module)
    {
        Artisan::call('module:migrate-reset ' . $module->name);

        Storage::disk('addons')->deleteDirectory($module->name);

        $module->delete();
        return $this->success('模块删除成功');
    }

    public function syncLocalModule()
    {
        app('module')->syncModule();
        return $this->success('模型同步成功');
    }
}
