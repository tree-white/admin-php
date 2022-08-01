<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request, UserService $userService)
    {
        $user = User::where($userService->fieldName(), $request->account)->first();
        if (!$user) {
            throw ValidationException::withMessages([
                'account' => '用户不存在'
            ]);
        }

        if (!Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'password' => '密码输入错误'
            ]);
        }

        return [
            'info' => $user,
            'token' => $user->createToken('auth')->plainTextToken
        ];
    }
}
