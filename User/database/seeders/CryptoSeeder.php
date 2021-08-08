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
        CryptoCurrency::insert([
            [
                'name' => 'Bitcoin',
                'iso' => 'BTC',
                'description' => '',
                'is_active' => true,
            ],[
                'name' => 'Cardano',
                'iso' => 'ADA',
                'description' => '',
                'is_active' => false,
            ],[
                'name' => 'Bitcoin Cash',
                'iso' => 'BCH',
                'description' => '',
                'is_active' => false,
            ],[
                'name' => 'Binance coin',
                'iso' => 'BNB',
                'description' => '',
                'is_active' => false,
            ],[
                'name' => 'Tron',
                'iso' => 'TRX',
                'description' => '',
                'is_active' => false,
            ]
        ]);
        User::first()->wallets()->create([
            'crypto_currency_id' => 1,
            'address' => '1A1zP1eP5QGefi2DMPTfTL5SLmv7DivfNa',
        ]);
    }
}
