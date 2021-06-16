<?php

use App\Models\EmailSetting;
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
    if(DB::table('email_settings')->exists()){
        $setting = EmailSetting::query()->where('key',$key)->first();
        if($setting && !empty($setting->value))
            return $setting->toArray();
    }

    if(isset(EMAIL_SETTINGS[$key]))
        return EMAIL_SETTINGS[$key];

    throw new Exception(trans('responses.main-key-settings-is-missing'));
}




function hyphenate($str,int $every = 3) {
    return implode("-", str_split($str, $every));
}

function sumUp(array $intervals,int $key){
    $all_numeric = true;
    foreach ($intervals as $sub_keys) {
        if (!(is_numeric($sub_keys))) {
            $all_numeric = false;
            break;
        }
    }
    if(!$all_numeric)
        return 0;

    if($key == 0)
        return 0;
    return $intervals[$key-1] + sumUp($intervals,$key-1);
}
