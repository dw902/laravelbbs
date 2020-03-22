<?php

namespace App\Models;

class Reply extends Model
{
//    此处一定要有逗号才能不报错
    protected $fillable = [
        'content',
    ];

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
