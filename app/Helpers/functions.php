<?php

use App\Models\Setting;
use Illuminate\Support\Facades\DB;

function getSetting($key){
    if(!DB::table('settings')->exists())
        throw new Exception(trans('responses.no-settings-table'));
    $key = Setting::query()->where('key',$key)->first();
    if($key && !empty($key->value))
        return $key->value;
    if(isset(SETTINGS[$key]) && isset(SETTINGS[$key]['value']))
        return SETTINGS[$key]['value'];

    throw new Exception(trans('responses.main-key-settings-is-missing'));
}
