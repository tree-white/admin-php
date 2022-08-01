<?php

namespace App\Services;

class UserService
{
    /**
     * 登录要使用的字段
     */
    public function fieldName()
    {
        return
            filter_var(request('account'), FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile';
    }
}
