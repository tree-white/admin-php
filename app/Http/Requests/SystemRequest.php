<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SystemRequest extends FormRequest
{
    public function authorize()
    {
        return is_super_admin();
    }

    public function rules()
    {
        return [
            'config.site.title' => ['required'],
            'config.site.copyright' => ['required'],
            'config.site.logo' => ['required'],
            'config.code.expire' => ['required', 'numeric'],
            'config.code.timeout' => ['required', 'numeric'],
            'config.code.length' => ['required', 'numeric'],
        ];
    }

    public function attributes()
    {
        return [
            'config.site.title' => '站点名称',
            'config.site.copyright' => '版权信息',
            'config.site.logo' => '站点图标',
            'config.code.expire' => '验证码有效期',
            'config.code.timeout' => '验证码间隔',
            'config.code.length' => '验证码间隔',
        ];
    }
}
