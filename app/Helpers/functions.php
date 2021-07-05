<?php

use App\Models\EmailContentSetting;
use App\Models\LoginAttemptSetting;
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
    if(DB::table('email_content_settings')->exists()){
        $setting = EmailContentSetting::query()->where('key',$key)->first();
        if($setting && !empty($setting->value))
            return $setting->toArray();
    }

    if(isset(EMAIL_CONTENT_SETTINGS[$key]))
        return EMAIL_CONTENT_SETTINGS[$key];

    throw new Exception(trans('responses.main-key-settings-is-missing'));
}

function getLoginAttemptSetting(){
    $intervals = [];
    $tries = [];
    if(DB::table('login_attempt_settings')->exists() && LoginAttemptSetting::query()->get()->count() > 0){
        $intervals_db = LoginAttemptSetting::query()->orderBy('priority','ASC')->get();
        foreach ($intervals_db as $ri){
            $intervals [] = $ri->blocking_duration + $ri->duration;
            $tries [] = $ri->times;
        }
        return array($intervals,$tries);
    }


    if(isset(LOGIN_ATTEMPT_SETTINGS[0])){
        foreach (LOGIN_ATTEMPT_SETTINGS as $ri){
            $intervals[] = $ri['blocking_duration'] + $ri['duration'];
            $tries[] = $ri['times'];
        }
        return array($intervals,$tries);
    }

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

use Illuminate\Http\JsonResponse;
use ApiResponse\APIResponse;
use ApiResponse\Contracts\ApiInterface;

if (!function_exists('api')) {

    /**
     * Create a new APIResponse instance.
     *
     * @param int    $status
     * @param string $message
     * @param array  $data
     * @param array  $extraData
     *
     * @return APIResponse|JsonResponse
     */
    function api($status = 200, $message = '', $data = [], ...$extraData)
    {
        if (func_num_args() === 0) {
            return app(ApiInterface::class);
        }

        return app(ApiInterface::class)->response($status, $message, $data, ...$extraData);
    }
}

if (!function_exists('ok')) {

    /**
     * Return success response.
     *
     * @param string $message
     * @param array  $data
     * @param array  $extraData
     *
     * @return JsonResponse
     */
    function ok($message = '', $data = [], ...$extraData)
    {
        return api()->ok($message, $data, ...$extraData);
    }
}

if (!function_exists('success')) {

    /**
     * Return success response.
     *
     * @param string $message
     * @param array  $data
     * @param array  $extraData
     *
     * @return JsonResponse
     */
    function success($message = '', $data = [], ...$extraData)
    {
        return api()->success($message, $data, ...$extraData);
    }
}
