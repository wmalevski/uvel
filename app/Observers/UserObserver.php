<?php

namespace App\Observers;

use App\User;
use App\UserGroup;

class UserObserver
{
    public function creating(User $user)
    {
        $emailDomain = '@'.substr(strrchr($user->email, "@"), 1);
        $userGroup = UserGroup::where('domain', $emailDomain)->first();

        if ($userGroup) {
            $user->user_groups_id = $userGroup->id;
        }
    }
}
