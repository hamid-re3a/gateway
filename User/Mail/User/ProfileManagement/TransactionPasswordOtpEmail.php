<?php

namespace User\Mail\User\ProfileManagement;

use User\Mail\SettingableMail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TransactionPasswordOtpEmail extends Mailable implements SettingableMail
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
    public function __construct($user, $token)
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

        $setting['body'] = str_replace('{{full_name}}',(is_null($this->user->full_name) || empty($this->user->full_name)) ? 'Unknown': $this->user->full_name,$setting['body']);
        $setting['body'] = str_replace('{{otp}}',(is_null(hyphenate($this->token)) || empty(hyphenate($this->token))) ? 'Unknown': hyphenate($this->token),$setting['body']);
        $setting['body'] = str_replace('{{otp_expire_duration}}',(is_null(secondsToHumanReadable(getSetting("USER_EMAIL_VERIFICATION_OTP_DURATION"))) || empty(secondsToHumanReadable(getSetting("USER_EMAIL_VERIFICATION_OTP_DURATION")))) ? 'Unknown': secondsToHumanReadable(getSetting("USER_EMAIL_VERIFICATION_OTP_DURATION")),$setting['body']);

        return $this
            ->from($setting['from'], $setting['from_name'])
            ->subject($setting['subject'])
            ->html( $setting['body']);
    }

    public function getSetting() : array
    {
        return [

            'is_active' => true,
            'subject'=>'Transaction Password OTP',
            'from'=>'support@janex.com',
            'from_name'=>'Janex Support Team',
            'body'=><<<EOT
                <div>
                <p>Hello {{full_name}},</p>
                <p>To change your transaction password, please use the below code</p>
                <p></p>
                <h2 style="text-align: center;"><span style="background-color: #ffff00;"> {{otp}}</span></h2>
                <p><span style="background-color: #ffff00;"></span></p>
                <p>This code is valid only for {{otp_expire_duration}}. You will need to request another code once expired</p>
                <p>Cheers,</p>
                <p>Janex Support Team</p>
                </div>
            EOT,
            'variables'=>'full_name,otp,otp_expire_duration',
            'variables_description'=>'full_name user full name, otp otp token',
            'type'=>'email',
        ];
    }
}
