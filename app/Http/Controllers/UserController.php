<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public  function info()
    {
        return $this->success(data: new UserResource(auth()->user()));
    }

    public function index()
    {
        $users = User::when(request('key'), function ($query, $key) {
            $query->where($key, 'like', "%" . request('content') . "%");
        })->paginate(10);
        return UserResource::collection($users);
    }

    public function store(Request $request)
    {
        //
    }

    public function show(User $user)
    {
        return $this->success(data: new UserResource($user));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
