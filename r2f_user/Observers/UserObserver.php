<?php

namespace R2FUser\Observers;

use R2FUser\Models\UserBlockHistory;
use R2FUser\Jobs\EmailJob;
use R2FUser\Mail\User\WelcomeEmail;
use R2FUser\Models\User;
use Illuminate\Support\Facades\Mail;

class UserObserver
{

    public function updating(User $user)
    {
        $data = $user->all()->find($user->id)->toArray();
        if($user->isDirty('password')){
            $actor = $user->id;
            if(auth()->check()){
                $actor = auth()->user()->id;
            }
            $user->passwordHistories()->create([
                'actor_id'  => $actor,
                'password' => $data['password'],
            ]);
        }
        if($user->isDirty('block_type')){

            $actor = null;
            if(auth()->check() && $user->block_type != USER_BLOCK_TYPE_AUTOMATIC ){
                $actor = auth()->user()->id;
            }
            $user->blockHistories()->create([
                'actor_id'  => $actor,
                'block_type' => $data['block_type'],
                'block_reason' => $data['block_type']
            ]);

        }
    }

}
