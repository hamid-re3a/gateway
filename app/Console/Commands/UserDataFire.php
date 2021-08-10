<?php

namespace App\Console\Commands;

use App\Jobs\User\UserDataJob;
use Illuminate\Console\Command;
use User\Services\User;

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
        $user = new User();
        $user->setId(1);
        $user->setEmail("d@d.com");
        $user->setFirstName("Dariush");
        $user->setLastName("Molaie");
        $user->setRole('admin,client,dsafs');
        $serializeUser = serialize($user);

        UserDataJob::dispatch($serializeUser)->onQueue('subscriptions');
    }
}
