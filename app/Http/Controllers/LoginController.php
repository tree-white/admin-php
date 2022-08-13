<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
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
        return $this->success('登录成功', [
            'info' => new UserResource($user),
            'token' => $user->createToken('auth')->plainTextToken
        ]);
    }
}
