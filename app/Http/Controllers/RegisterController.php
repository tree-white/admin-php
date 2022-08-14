<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
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

        return $this->success('注册成功', [
            // $user->refresh() 刷新创建后最新的数据库用户数据
            'info' => new UserResource($user->refresh()),
            'token' => $user->createToken('auth')->plainTextToken
        ]);
    }
}
