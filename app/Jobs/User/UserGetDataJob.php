<?php

namespace App\Jobs\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use User\Services\UserAdminService;

class UserGetDataJob implements ShouldQueue
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
        $user_get_data_serialize = unserialize($this->data);
        $user_data = app(UserAdminService::class)->getUserData($user_get_data_serialize);
        $user_data_serialize = serialize($user_data);
        Log::info("get user info and produce for service request sender",[$user_data]);
        UserDataJob::dispatch($user_data_serialize)->onConnection('rabbit')->onQueue($user_get_data_serialize->getQueueName());
    }
}
