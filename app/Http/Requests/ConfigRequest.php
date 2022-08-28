<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfigRequest extends FormRequest
{
    public function authorize()
    {
        return is_super_admin();
    }

    public function rules()
    {
        return [
            'site.title' => ['required'],
            'site.copyright' => ['required'],
            'site.logo' => ['required'],
            'code.expire' => ['required', 'numeric'],
            'code.timeout' => ['required', 'numeric'],
            'code.length' => ['required', 'numeric'],
        ];
    }

    public function attributes()
    {
        return [
            'site.title' => '站点名称',
            'site.copyright' => '版权信息',
            'site.logo' => '站点图标',
            'code.expire' => '验证码有效期',
            'code.timeout' => '验证码间隔',
            'code.length' => '验证码间隔',
        ];
    }
}
