<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request, UserService $userService)
    {
        $user = User::create([
            $userService->fieldName() => $request->account,
            'password' => Hash::make($request->password),
        ]);

        return [
            // $user->refresh() 刷新创建后最新的数据库用户数据
            'info' => $user->refresh(),
            'token' => $user->createToken('auth')->plainTextToken
        ];
    }
}
