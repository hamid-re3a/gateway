<?php

namespace User\Observers;

use App\Jobs\User\UserDataJob;
use User\Mail\User\UserAccountActivatedEmail;
use User\Jobs\TrivialEmailJob;
use User\Models\User;

class UserObserver
{

    public function updating(User $user)
    {
        if(auth()->check()) {
            $data = $user->all()->find($user->id)->toArray();
            $attributes = array_merge($data,[
                'actor_id' => request()->user()->id
            ]);
            $history = $user->userHistories()->create($attributes);

            if(!empty($user->isDirty())){
                $userObject = new \User\Services\User();
                $userObject->setId($user->id);
                $userObject->setEmail($user->email);
                $userObject->setFirstName($user->first_name);
                $role_name = implode(",",$user->getRoleNames()->toArray());
                $userObject->setRole($role_name);
                $serializeUser = serialize($userObject);
                UserDataJob::dispatch($serializeUser)->onQueue('subscriptions');
                UserDataJob::dispatch($serializeUser)->onQueue('kyc');
                UserDataJob::dispatch($serializeUser)->onQueue('mlm');
            }

            if($user->isDirty('block_type')){

                if($data['block_type'] != USER_BLOCK_TYPE_AUTOMATIC)
                    TrivialEmailJob::dispatch(new UserAccountActivatedEmail($user,$history),$user->email);

            }
        }
    }

}
