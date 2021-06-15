<?php

namespace R2FUser\Observers;

use R2FUser\Jobs\EmailJob;
use R2FUser\Mail\User\WelcomeEmail;
use R2FUser\Models\User;
use Illuminate\Support\Facades\Mail;

class UserObserver
{

    public function created(User $user)
    {

    }

}
