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
    private $user_service;

    public function __construct($data,UserService $userService)
    {
        $this->data = $data;
        $this->user_service = $userService;
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
        if($user_db AND $user_object instanceof \User\Services\User)
            $this->user_service->userUpdate($user_object);
    }
}
