<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum'])->only(['toggle']);
    }

    /** 获取关注列表 */
    public function index(User $user)
    {
        $followers = $user->followers;
        return $this->success('获取成功', $followers);
    }

    /** 关注用户 */
    public function toggle(User $user)
    {
        Auth::user()->followers()->toggle($user);
        return $this->success(data: Auth::user()->isFollower($user));
    }
}
