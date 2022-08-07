<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePermissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        /**
         * 判断字段是否唯一的两种方式
         * 1：unique:表名, 列明
         * 2：Rule::unique('表名', '列名')
         */
        return [
            'name' => ['required', 'unique:permissions,name'],
            'title' => ['required', Rule::unique('permissions', 'title')]
        ];
    }
}
