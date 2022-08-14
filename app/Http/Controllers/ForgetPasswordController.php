<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgetPasswordRequest;
use App\Http\Resources\UserResource;
use App\Models\User;

class ForgetPasswordController extends Controller
{
    public function __invoke(ForgetPasswordRequest $request)
    {
        $user = User::where(app('user')->fieldName(), $request->account)->first();
        $user->password = bcrypt($request->password);
        $user->save();

        return $this->success('密码修改成功', [
            'info' => new UserResource($user->refresh()),
            'token' => $user->createToken('auth')->plainTextToken
        ]);
    }
}
