<?php

namespace R2FUser\Support;

use App\Models\UserAgent;
use MaxMind\Db\Reader\InvalidDatabaseException;
use PragmaRX\Google2FALaravel\Exceptions\InvalidSecretKey;

class GeoIp
{
    public static function getInfo($ip)
    {
        if (!$ip)
            $ip = request()->ip();

        try {
            $reader = new \GeoIp2\Database\Reader(storage_path('app/new_geoip.mmdb'));
            $city = $reader->city($ip);
            $user_agent = new UserAgent();
            $user_agent->iso_code = $city->country->isoCode;
            $user_agent->country = $city->country->name;
            $user_agent->city = $city->city->name;
            $user_agent->postal_code = $city->postal->code;
            $user_agent->lat = $city->location->latitude;
            $user_agent->lon = $city->location->longitude;
            $user_agent->timezone = $city->location->timeZone;
            $user_agent->continent = $city->continent->name;
            $user_agent->state_name = $city->mostSpecificSubdivision->name;
            $user_agent->state = $city->mostSpecificSubdivision->isoCode;
            return $user_agent;
        } catch (InvalidDatabaseException $e) {
        }
    }


}
