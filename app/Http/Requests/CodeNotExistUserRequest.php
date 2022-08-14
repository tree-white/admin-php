<?php

namespace App\Http\Requests;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class CodeNotExistUserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'account' => ['required', $this->accountRule(), $this->checkUserNotExists()],
        ];
    }

    /** 判断适用邮箱还是手机规则验证 */
    protected function accountRule()
    {
        return $this->fieldName() == 'email' ? 'email' : 'regex:/^\d{11}$/';
    }

    /** 获取账号类型字段名 */
    protected function fieldName()
    {
        return filter_var(request('account'), FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile';
    }

    /** 检查用户是否存在 */
    protected function checkUserNotExists()
    {
        return function ($validate, $value, $fail) {
            $isExists = User::where($this->fieldName(), $value)->exists();
            if ($isExists) {
                $fail('该账号已存在');
            };
        };
    }
}
