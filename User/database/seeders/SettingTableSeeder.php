<?php

namespace User\database\seeders;

use User\Models\EmailContentSetting;
use User\Models\LoginAttemptSetting;
use User\Models\Setting;
use Illuminate\Database\Seeder;
use User\Models\LoginAttempt;

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
        foreach (EMAIL_CONTENT_SETTINGS as $key => $setting) {

            if (!EmailContentSetting::query()->whereKey($key)->exists()) {
                EmailContentSetting::query()->create([
                    'key' => $key,
                    'is_active' => $setting['is_active'],
                    'subject' => $setting['subject'],
                    'from' => $setting['from'],
                    'from_name' => $setting['from_name'],
                    'body' => $setting['body'],
                    'variables' => $setting['variables'],
                    'variables_description' => $setting['variables_description'],
                    'type' => $setting['type'],
                ]);
            }
        }

        if (LoginAttemptSetting::query()->get()->count() == 0) {
            foreach (LOGIN_ATTEMPT_SETTINGS as $key => $setting) {

                LoginAttemptSetting::query()->create([
                    'times' => $setting['times'],
                    'duration' => $setting['duration'],
                    'priority' => $setting['priority'],
                    'blocking_duration' => $setting['blocking_duration'],
                ]);
            }
        }
    }
}
