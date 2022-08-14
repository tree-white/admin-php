<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidateCodeRequest;
use App\Services\CodeService;
use Illuminate\Support\Facades\Auth;

class ValidateCodeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum'])->only(['user']);
    }

    // 任何用户发送验证码
    public function send(ValidateCodeRequest $request, CodeService $codeService)
    {
        $codeService->send($request->account);
        return $this->success('验证码发送成功');
    }

    // 发送当前请求的用户验证码
    public function user(string $type, CodeService $codeService)
    {
        $codeService->send(Auth::user()[$type]);
        return $this->success('验证码发送成功');
    }
}
