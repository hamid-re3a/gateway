<?php

namespace User\Observers;

use User\Mail\User\UserAccountActivatedEmail;
use User\Jobs\TrivialEmailJob;
use User\Models\User;

class UserObserver
{

    public function updating(User $user)
    {
        if(auth()->check()) {
            $data = $user->getOriginal();
            $attributes = array_merge($data,[
                'actor_id' => request()->user()->id,
                'user_id' => $data['id']
            ]);
            $history = $user->userHistories()->create($attributes);

            if($user->isDirty('block_type')){

                if($data['block_type'] != USER_BLOCK_TYPE_AUTOMATIC)
                    TrivialEmailJob::dispatch(new UserAccountActivatedEmail($user,$history),$user->email);

            }
        }
    }

}
