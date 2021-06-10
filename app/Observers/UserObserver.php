<?php

namespace App\Observers;

use App\Mail\User\WelcomeEMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class UserObserver
{

    public function created(User $user)
    {
        if(env('APP_ENV') != 'testing'){
            Mail::to($user->email)->send(new WelcomeEMail($user));
        }
    }

}
