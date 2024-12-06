<?php

namespace App\Observers;

use App\User;
use App\UserGroup;

class UserGroupObserver
{
    public function created(UserGroup $userGroup) : void
    {
        $this->massUserUpdate($userGroup, $userGroup->id);
    }

    public function deleted(UserGroup $userGroup) : void
    {
        $this->massUserUpdate($userGroup, null);
    }

    public function updated(UserGroup $userGroup) : void
    {
        $this->massUserUpdate($userGroup, $userGroup->id);
    }

    private function massUserUpdate(UserGroup $userGroup, $groupId = null) : void
    {
        $users = User::select('id', 'user_groups_id')
            ->where('email', 'like', '%' . $userGroup->domain . '%')
            ->get();

        if ($users->isNotEmpty()) {
            $usersArray = $users->map(function ($user) use ($userGroup, $groupId) {
                return [
                    'id' => $user->id,
                    'user_groups_id' => $groupId
                ];
            })->toArray();

            (new User())->batchUpdate($usersArray, 'id');
        }
    }
}
