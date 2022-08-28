<?php

namespace App\Http\Controllers;

use App\Http\Requests\SystemRequest;
use App\Http\Resources\SystemResource;
use App\Models\System;
use Illuminate\Http\Request;

class SystemController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
    }

    public function update(SystemRequest $request)
    {
        $system = System::firstOrFail();
        $system->fill($request->input())->save();
        return $this->success('配置更新成功');
    }

    public function get(Request $request)
    {
        return $this->success(data: new SystemResource(System::firstOrFail()));
    }
}
