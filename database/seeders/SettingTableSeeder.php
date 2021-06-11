<?php

namespace Database\Seeders;

use App\Models\EmailAndTextSetting;
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
        foreach (SETTINGS as $key => $setting) {
            $key = Setting::query()->firstOrCreate([
                'key' => $key
            ]);
            if (is_null($key->value)) {
                $key->value = $setting['value'];
                $key->description = $setting['description'];
                $key->category = $setting['category'];
                $key->save();
            }
        }
        foreach (EMAIL_AND_TEXT_SETTINGS as $key => $setting) {

            if (!EmailAndTextSetting::query()->whereKey($key)->exists()) {
                EmailAndTextSetting::query()->create([
                    'key' => $key,
                    'subject' => $setting['subject'],
                    'from' => $setting['from'],
                    'from_name' => $setting['from_name'],
                    'body' => $setting['body'],
                    'variables_number' => $setting['variables_number'],
                    'variables_description' => $setting['variables_description'],
                    'type' => $setting['type'],
                ]);
            }
        }

    }
}
