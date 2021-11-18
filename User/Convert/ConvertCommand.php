<?php

namespace User\Convert;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Validation\Rules\In;
use User\Convert\Models\Individual;
use User\Models\User;

class ConvertCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert';

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
        $count = Individual::query()->count();
        $this->info(PHP_EOL . 'number of user rows ' . $count . PHP_EOL);

        $bar = $this->output->createProgressBar($count);

        $this->info(PHP_EOL . 'Start user conversion');
        $bar->start();
        $users = Individual::with('detail')->
        chunk(50, function ($users) use ($bar) {

            foreach ($users as $item) {
                $current_user = User::query()->find($item->id);
                if (!$current_user)
                    $current_user = User::factory()->create(['id' => $item->id]);
                if (!is_null($item->detail)
                    && !is_null($item->detail->user_detail_email)
                    && !empty($item->detail->user_detail_email) &&
                    filter_var($item->detail->user_detail_email, FILTER_VALIDATE_EMAIL)
                ) {
                    if (User::query()->where('email', $item->detail->user_detail_email)->exists())
                        $email = $item->user_name . '@dreamcometrue.ai';
                    else
                        $email = $item->detail->user_detail_email;
                } else {
                    $email = $item->user_name . '@dreamcometrue.ai';
                }

                if (!is_null($item->user_name)) {
                    if (User::query()->where('username', $item->user_name)->exists())
                        $username = $item->user_name . random_int(99,999);
                    else
                        $username = $item->user_name;
                } else {
                    $username = \Str::random();
                }

                $current_user->update([
                    'email' => $email,
                    'password' => $item->user_name,
                    'transaction_password' => $item->user_name,
                    'first_name' => (!is_null($item->detail) && !is_null($item->detail->user_detail_name)) ? $item->detail->user_detail_name : "Unknown",
                    'last_name' => (!is_null($item->detail) && !is_null($item->detail->user_detail_second_name)) ? $item->detail->user_detail_second_name : "Unknown",
                    'passport_number' => (!is_null($item->detail) && !is_null($item->detail->passport_no)) ? $item->detail->passport_no : null,
                    'address_line1' => (!is_null($item->detail) && !is_null($item->detail->user_detail_address)) ? $item->detail->user_detail_address : null,
                    'address_line2' => (!is_null($item->detail) && !is_null($item->detail->user_detail_address2)) ? $item->detail->user_detail_address2 : null,
//                    'landline_number' => (!is_null($item->detail) && !is_null($item->detail->user_detail_land)) ? $item->detail->user_detail_land : null,
                    'zip_code' => (!is_null($item->detail) && !is_null($item->detail->user_detail_pin)) ? $item->detail->user_detail_pin : null,
//                    'mobile_number' => (!is_null($item->detail) && !is_null($item->detail->user_detail_mobile)) ? $item->detail->user_detail_mobile : null,
                    'birthday' => (!is_null($item->detail) && !is_null($item->detail->user_detail_dob)) ? Carbon::make($item->detail->user_detail_dob)->toDate() : null,
                    'gender' => (!is_null($item->detail) && !is_null($item->detail->user_detail_gender)) ? ($item->detail->user_detail_gender == "F") ? "Female" : "Male" : "Male",
                    'sponsor_id' => $item->sponsor_id,
                    'username' => $username,
                    'email_verified_at' => now()
                ]);
                $current_user->assignRole(USER_ROLE_CLIENT);
                $bar->advance();
            }


        });

        $bar->finish();
        $this->info(PHP_EOL . 'User Conversion Finished' . PHP_EOL);
    }


}
