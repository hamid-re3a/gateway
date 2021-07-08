<?php

namespace User\Mail\User;

use User\Mail\SettingableMail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgetPasswordOtpEmail extends Mailable implements SettingableMail
{
    use Queueable, SerializesModels;

    public $user;
    public $token;

    /**
     * Create a new message instance.
     *
     * @param $user
     * @param $token
     */
    public function __construct($user,$token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     * @throws \Exception
     */
    public function build()
    {
        $setting = $this->getSetting();

        $setting['body'] = str_replace('{{full_name}}',$this->user->full_name,$setting['body']);
        $setting['body'] = str_replace('{{otp}}',hyphenate($this->token),$setting['body']);
        $setting['body'] = str_replace('{{otp_expire_duration}}',getSetting("USER_FORGOT_PASSWORD_OTP_DURATION"),$setting['body']);

        return $this
            ->from($setting['from'], $setting['from_name'])
            ->subject($setting['subject'])
            ->html($setting['body']);
    }

    public function getSetting(): array
    {
        return getEmailAndTextSetting('FORGOT_PASSWORD_OTP_EMAIL');
    }
}
