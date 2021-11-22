<?php

namespace User\Convert;

use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
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
        ini_set('memory_limit', '-1');
        $count = Individual::query()->count();
        $this->info(PHP_EOL . 'number of user rows ' . $count . PHP_EOL);

        $bar = $this->output->createProgressBar($count);

        $this->info(PHP_EOL . 'Start user conversion');
        $bar->start();
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique('users_unique_email');
            $table->dropUnique('users_unique_username');
        });
        Individual::with('detail')->
        chunk(5000, function ($users) use ($bar) {
            $last_users = [];
            $last_user_roles = [];
            foreach ($users as $item) {


                if (!is_null($item->detail)
                    && !is_null($item->detail->user_detail_email)
                    && !empty($item->detail->user_detail_email) &&
                    filter_var($item->detail->user_detail_email, FILTER_VALIDATE_EMAIL)
                ) {
                    if (User::query()->where('email', $item->detail->user_detail_email)->exists() || collect($last_users)->firstWhere('email', $item->detail->user_detail_email) !== null)
                        $email = $item->user_name . random_int(99, 999) . '@dreamcometrue.ai';
                    else
                        $email = $item->detail->user_detail_email;
                } else {
                    $email = $item->user_name . '@dreamcometrue.ai';
                }

                if (!is_null($item->user_name)) {
                    if (User::query()->where('username', $item->user_name)->exists() || collect($last_users)->firstWhere('username', $item->user_name) !== null)
                        $username = $item->user_name . random_int(99, 999);
                    else
                        $username = $item->user_name;
                } else {
                    $username = \Str::random();
                }
                $last_user_roles[] = [
                    'model_id' => $item->id,
                    'model_type' => 'User\Models\User',
                    'role_id' => 10,
                ];
                $last_users[] = [
                    'id' => $item->id,
                    'email' => $email,
                    'username' => $username,
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
                    'email_verified_at' => now()
                ];
//                $current_user->assignRole(USER_ROLE_CLIENT);
                $bar->advance();
            }
            $insert_data = collect($last_users);
            $chunks = $insert_data->chunk(500);

            foreach ($chunks as $chunk) {
                DB::table('users')->insert($chunk->toArray());

            }
            $insert_data = collect($last_user_roles);
            $chunks = $insert_data->chunk(500);

            foreach ($chunks as $chunk) {
                DB::table('model_has_roles')->insert($chunk->toArray());

            }
        });
        Schema::table('users', function (Blueprint $table) {
            $table->unique('email', 'users_unique_email');
            $table->unique('username', 'users_unique_username');
        });
        $bar->finish();
        $this->info(PHP_EOL . 'User Conversion Finished' . PHP_EOL);
    }


}
