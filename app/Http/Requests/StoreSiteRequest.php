<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreSiteRequest extends FormRequest
{
    // /**
    //  * Determine if the user is authorized to make this request.
    //  *
    //  * @return bool
    //  */
    // public function authorize()
    // {
    //     return Auth::check();
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => ['required', 'between:3,50', Rule::unique('sites')],
            'url' => ['nullable', 'url'],
            'email' => ['nullable', 'email'],
            'address' => ['nullable', 'max:100']
        ];
    }

    public function attributes()
    {
        return ['title' => '网站名称', 'url' => '网址',];
    }
}
