<?php

namespace User\Observers;

use App\Jobs\User\UserDataJob;
use User\Mail\User\UserAccountActivatedEmail;
use User\Jobs\TrivialEmailJob;
use User\Models\User;

class UserObserver
{
    public function creating(User $user)
    {
        if(empty($user->member_id)) {
            //User member_id field
            $member_id = mt_rand(121212121,999999999);
            while ($user->where('member_id', $member_id)->count())
                $member_id = mt_rand(121212121,999999999);
            $user->member_id = $member_id;
        }
    }

    public function updating(User $user)
    {
        if(auth()->check()) {
            $data = $user->getOriginal();
            $attributes = array_merge($data,[
                'actor_id' => request()->user()->id,
                'user_id' => $data['id']
            ]);
            $history = $user->userHistories()->create($attributes);

            if(!empty($user->isDirty())){
                $userObject = new \User\Services\User();
                $userObject->setId($user->id);
                $userObject->setEmail($user->email);
                $userObject->setFirstName($user->first_name);
                $userObject->setLastName($user->last_name);
                $userObject->setUsername($user->username);
                $userObject->setBlockType($user->block_type);
                $userObject->setIsDeactivate($user->is_deactivate);
                $userObject->setIsFreeze($user->is_freeze);
                $userObject->setSponsorId($user->sponsor_id);
                $role_name = implode(",",$user->getRoleNames()->toArray());
                $userObject->setRole($role_name);
                $serializeUser = serialize($userObject);
                UserDataJob::dispatch($serializeUser)->onConnection('rabbit')->onQueue('subscriptions');
                UserDataJob::dispatch($serializeUser)->onConnection('rabbit')->onQueue('kyc');
                UserDataJob::dispatch($serializeUser)->onConnection('rabbit')->onQueue('mlm');
            }

            if($user->isDirty('block_type')){

                if($data['block_type'] != USER_BLOCK_TYPE_AUTOMATIC)
                    TrivialEmailJob::dispatch(new UserAccountActivatedEmail($user,$history),$user->email);

            }
        }
    }

}
