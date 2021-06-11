<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

/**
 * Class AuthTableSeeder.
 */
class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (SETTINGS as $key=>$setting) {
            $key = Setting::query()->firstOrCreate([
                'key' => $key
            ]);
            if(is_null($key->value)){
                $key->value = $setting['value'];
                $key->description = $setting['description'];
                $key->category = $setting['category'];
                $key->save();
            }
        }

    }
}
