<?php

namespace App\Jobs\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use User\Models\User;
use User\Services\UserAdminService;
use User\Services\UserService;

class UpdateUserJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /**
         * @var $user_service \User\Services\User
         */
        $user_object = unserialize($this->data);
        $user_db = User::query()->find($user_object->getId());
        if($user_db) {
            $user_service = app(UserAdminService::class);
            $user_object = $user_service->userUpdate($user_object);
            if($user_object instanceof \User\Services\User) {
                $serialize_user = serialize($user_object);
                UserDataJob::dispatch($serialize_user)->onConnection('rabbit')->onQueue('subscriptions');
                UserDataJob::dispatch($serialize_user)->onConnection('rabbit')->onQueue('kyc');
            }
        }
    }
}
