<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\UserDataJob;

class UserDataFire extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'userFire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $data = [
          "name"=>"dariush" ,
          "email"=>"test@test.com"
        ];
        UserDataJob::dispatch($data)->onConnection('kyc');
    }
}
