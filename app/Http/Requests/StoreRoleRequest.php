<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => ['required', $this->uniqueFilter('title')],
            'name' => ['required', 'regex:/^[a-z]+$/i', $this->uniqueFilter('name')],
        ];
    }

    public function attributes()
    {
        return ['title' => '角色名称', 'name' => '角色标识'];
    }

    protected function uniqueFilter($field)
    {
        return Rule::unique('roles', $field)->where('site_id', request('site.id'))->whereNotIn('id', request('role.id'));
    }
}
