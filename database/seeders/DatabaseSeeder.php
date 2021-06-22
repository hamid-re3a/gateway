<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use R2FUser\database\seeders\AuthTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AuthTableSeeder::class);
        $this->call(SettingTableSeeder::class);
    }
}
