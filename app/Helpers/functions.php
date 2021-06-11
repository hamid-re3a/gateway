<?php

use App\Models\EmailAndTextSetting;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;

function getSetting($key){
    if(DB::table('settings')->exists()){
        $key_db = Setting::query()->where('key',$key)->first();
        if($key_db && !empty($key_db->value))
            return $key_db->value;
    }

    if(isset(SETTINGS[$key]) && isset(SETTINGS[$key]['value']))
        return SETTINGS[$key]['value'];

    throw new Exception(trans('responses.main-key-settings-is-missing'));
}

function getEmailAndTextSetting($key){
    if(DB::table('email_and_text_settings')->exists()){
        $setting = EmailAndTextSetting::query()->where('key',$key)->first();
        if($setting && !empty($setting->value))
            return $setting->toArray();
    }

    if(isset(EMAIL_AND_TEXT_SETTINGS[$key]))
        return EMAIL_AND_TEXT_SETTINGS[$key];

    throw new Exception(trans('responses.main-key-settings-is-missing'));
}
