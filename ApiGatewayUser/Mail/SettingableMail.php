<?php


namespace ApiGatewayUser\Mail;

use App\Models\EmailContentSetting;

interface SettingableMail
{
    public function getSetting(): array ;
}
