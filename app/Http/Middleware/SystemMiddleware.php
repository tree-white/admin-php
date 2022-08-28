<?php

namespace App\Http\Middleware;

use App\Models\System;
use Closure;
use Illuminate\Http\Request;

class SystemMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // $config = System::where('name', 'system')->firstOrNew()->toArray();
        // config(['system' => empty($config) ? config('system') : $config['data']]);

        $this->loadSystem('system', config('system'));

        return $next($request);
    }

    protected function loadSystem(string $module, $config = [])
    {
        // $data = System::where("name", $module)->firstOrFail()->data;
        $data = System::firstOrNew();
        foreach ($config as $key => $value) {
            $config[$key] = ($data['config'][$key] ?? []) + $value;
        };

        config(['system' => $config]);
    }
}
