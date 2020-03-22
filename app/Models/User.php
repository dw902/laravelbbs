<?php

namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
//use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
//邮件修改
class User extends Authenticatable implements MustVerifyEmailContract


{
    use Notifiable, MustVerifyEmailTrait;

    protected $fillable = [
        'name', 'email', 'password','introduction','avatar',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function topics()
    {
        return $this->hasMany(Topic::class);
    }
//    此处对police函数进行重构
    public function isAuthorOf($model)
    {
        return $this->id == $model->user_id;
    }
}
