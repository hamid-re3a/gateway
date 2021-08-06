<?php

namespace User\Observers;

use User\Mail\User\UserAccountActivatedEmail;
use User\Jobs\EmailJob;
use User\Models\User;

class UserObserver
{

    public function updating(User $user)
    {
        $data = $user->all()->find($user->id)->toArray();
        $attributes = array_merge($data,[
            'actor_id' => request()->user()->id
        ]);
        $history = $user->userHistories()->create($attributes);

        if($user->isDirty('block_type')){

            if($data['block_type'] != USER_BLOCK_TYPE_AUTOMATIC)
                EmailJob::dispatch(new UserAccountActivatedEmail($user,$history),$user->email);

        }
    }

}
