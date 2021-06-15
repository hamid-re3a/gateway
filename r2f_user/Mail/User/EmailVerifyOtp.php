<?php

namespace R2FUser\Mail\User;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailVerifyOtp extends Mailable
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
        $setting = getEmailAndTextSetting('EMAIL_VERIFICATION_OTP_EMAIL');

        $setting['body'] = str_replace('{{otp}}',$this->token,$setting['body']);
        $setting['body'] = str_replace('{{full_name}}',$this->user->full_name,$setting['body']);

        return $this
            ->from($setting['from'], $setting['from_name'])
            ->subject($setting['subject'])
            ->html( $setting['body']);
    }
}
