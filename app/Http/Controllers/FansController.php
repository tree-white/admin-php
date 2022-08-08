<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class FansController extends Controller
{
    public function index(User $user)
    {
        return $this->success('查询成功', UserResource::collection($user->fans));
    }
}
