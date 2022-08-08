<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guard_name = ['sanctum'];

    /**
     * 质量可分配的属性.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * 序列化时应隐藏的属性.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'unionid',
        'openid',
        'miniapp_openid',
    ];

    // 额外添加列
    protected $appends = ['avatar_url'];

    /**
     * 应强制转换的属性.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // 给列「avatar_url」添加属性
    public function getAvatarUrlAttribute()
    {
        return $this->avatar ?? url('images/avatar.jpeg');
    }

    /**
     * 关注列表
     */
    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');
    }

    /** 是否关注 */
    public function isFollower(User $user)
    {
        return $this->followers()->where('follower_id', $user->id)->exists();
    }

    /**
     * 粉丝列表
     */
    public function fans()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');
    }
}
