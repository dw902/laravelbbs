<?php

namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
//use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
//邮件修改
use Auth;
use Spatie\Permission\Traits\HasRoles;
class User extends Authenticatable implements MustVerifyEmailContract


{
//    use Notifiable, MustVerifyEmailTrait;
    use MustVerifyEmailTrait;

    use HasRoles;

    use Notifiable {
        notify as protected laravelNotify;
    }
    public function notify($instance)
    {
        // 如果要通知的人是当前用户，就不必通知了！
        if ($this->id == Auth::id()) {
            return;
        }

        // 只有数据库类型通知才需提醒，直接发送 Email 或者其他的都 Pass
        if (method_exists($instance, 'toDatabase')) {
            $this->increment('notification_count');
        }

        $this->laravelNotify($instance);
    }

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
//    一个用户可以有多条评论
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }
    public function markAsRead()
    {
        $this->notification_count = 0;
        $this->save();
        $this->unreadNotifications->markAsRead();
    }
}
