<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadAvatarRequest;
use App\Http\Requests\UploadImageRequest;
use Illuminate\Support\Facades\Auth;

class UploadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /** 上传头像 */
    public function avatar(UploadAvatarRequest $request)
    {
        $res = app('upload')->avatar($request->file);
        $user = Auth::user();
        $user->avatar = $res['url'];
        $user->save();
        return ['url' => $res['url']];
    }

    public function image(UploadImageRequest $request)
    {
        $res = app('upload')->file($request->file);
        return $this->success(data: $res['url']);
    }
}
