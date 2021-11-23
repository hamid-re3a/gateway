<?php

namespace User\database\seeders;

use Illuminate\Database\Seeder;
use User\Models\CryptoCurrency;
use User\Models\User;

/**
 * Class AuthTableSeeder.
 */
class CryptoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CryptoCurrency::query()->firstOrCreate(
            [
                'iso' => 'BTC',
            ],
            [
                'name' => 'Bitcoin',
                'description' => '',
                'is_active' => true,
            ],
            );
    }
}
