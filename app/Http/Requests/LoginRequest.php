<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'account' => [...$this->accountRule(), Rule::exists('users', $this->fieldName())],
            'password' => ['required', 'min:3', function ($attribute, $value, $fail) {
                $user = User::where($this->fieldName(), request('account'))->first();
                if ($user && !Hash::check($value, $user->password)) {
                    $fail('密码输入错误');
                }
            }],
            'captcha_code' => 'sometimes|required|captcha_api:' . request('captcha_key') . ',math'
        ];
    }

    /** 账号验证 */
    protected function accountRule()
    {
        switch ($this->fieldName()) {
            case 'email':
                return ['required', 'email'];
            case 'mobile':
                return ['required', 'regex:/^\d{11}$/'];
        }
    }

    /** 获取账号类型 */
    protected function fieldName()
    {
        return filter_var(request('account'), FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile';
    }

    public function messages()
    {
        return ['captcha_code.captcha_api' => '验证码输入错误'];
    }
}
