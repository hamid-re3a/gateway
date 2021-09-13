<?php

namespace App\Jobs\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use User\Models\User;

class RequestGetAllUserDataJob implements ShouldQueue
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


        $all_users = User::select(['id','first_name','last_name', 'username','email','member_id','block_type','is_deactivate', 'is_freeze','sponsor_id'])->with('roles:name')->get()->toArray();
        $user_serialize = serialize($all_users);
        GetAllUserDataJob::dispatch($user_serialize)->onConnection('rabbit')->onQueue($user_get_data_serialize->getQueueName());
        Log::info("consume user data and updated by data:");

        echo "event has been handle. the first name and last name of userData is:".$this->data. PHP_EOL;

    }
}
