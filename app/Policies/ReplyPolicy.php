<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Reply;

class ReplyPolicy extends Policy
{
//    更新刪除同一ge
//    public function update(User $user, Reply $reply)
//    {
//        // return $reply->user_id == $user->id;
//        return true;
//    }

//    public function destroy(User $user, Reply $reply)
//    {
//        return true;
//    }
    public function destroy(User $user, Reply $reply)
    {
        return $user->isAuthorOf($reply) || $user->isAuthorOf($reply->topic);
    }
}
