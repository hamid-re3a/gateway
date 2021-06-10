<?php

namespace Database\Seeders;

use Database\Seeders\Auth\PermissionRoleTableSeeder;
use Database\Seeders\Auth\UserRoleTableSeeder;
use Database\Seeders\Auth\UserTableSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Class AuthTableSeeder.
 */
class AuthTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()

    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
//        DB::table('users')->truncate();
        $this->call(PermissionRoleTableSeeder::class);
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

    }
}
