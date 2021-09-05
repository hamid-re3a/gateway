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
                $userObject = $user->getUserService();
                $serialize_user = serialize($userObject);
                $hash_user_service = md5($serialize_user);
                UserDataJob::dispatch($hash_user_service)->onConnection('rabbit')->onQueue('subscriptions');
                UserDataJob::dispatch($hash_user_service)->onConnection('rabbit')->onQueue('kyc');
                //UserDataJob::dispatch($hash_user_service)->onConnection('rabbit')->onQueue('mlm');
            }

            if($user->isDirty('block_type')){

                if($data['block_type'] != USER_BLOCK_TYPE_AUTOMATIC)
                    TrivialEmailJob::dispatch(new UserAccountActivatedEmail($user,$history),$user->email);

            }
        }
    }

}
