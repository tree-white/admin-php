<?php

namespace App\Http\Middleware;

use App\Models\Config;
use Closure;
use Illuminate\Http\Request;

class ConfigMiddleware
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
        // $config = Config::where('name', 'system')->firstOrNew()->toArray();
        // config(['system' => empty($config) ? config('system') : $config['data']]);

        $this->loadConfig('system', config('system'));

        return $next($request);
    }

    protected function loadConfig(string $module, $config = [])
    {
        $data = Config::where("name", $module)->firstOrFail()->data;
        foreach ($config as $key => $value) {
            $config[$key] = ($data[$key] ?? []) + $value;
        };

        config(['system' => $config]);
    }
}
