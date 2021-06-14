<?php

namespace R2FUser\Observers;

use R2FUser\Mail\User\WelcomeEmail;
use R2FUser\Models\User;
use Illuminate\Support\Facades\Mail;

class UserObserver
{

    public function created(User $user)
    {
        if(env('APP_ENV') != 'testing'){
            Mail::to($user->email)->send(new WelcomeEmail($user));
        }
    }

}
