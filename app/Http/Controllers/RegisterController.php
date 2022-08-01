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
            'info' => $user,
            'token' => $user->createToken('auth')->plainTextToken
        ];
    }
}
