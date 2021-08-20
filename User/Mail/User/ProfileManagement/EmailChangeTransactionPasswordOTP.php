<?php

namespace User\Mail\User\ProfileManagement;

use Illuminate\Support\Facades\Log;
use User\Mail\SettingableMail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use User\Models\EmailContentSetting;

class EmailChangeTransactionPasswordOTP extends Mailable implements SettingableMail
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
        $otpDuration = 60 ;
        try{
            if((is_null(secondsToHumanReadable(getSetting("USER_EMAIL_VERIFICATION_OTP_DURATION"))) || empty(secondsToHumanReadable(getSetting("USER_EMAIL_VERIFICATION_OTP_DURATION")))))
                $otpDuration = secondsToHumanReadable(getSetting("USER_EMAIL_VERIFICATION_OTP_DURATION"));
        } catch (\Throwable $exception) {
            Log::error('TransactionPasswordOTP email error for getSetting USER_EMAIL_VERIFICATION_OTP_DURATION');
        }

        $setting['body'] = str_replace('{{full_name}}',(is_null($this->user->full_name) || empty($this->user->full_name)) ? 'Unknown': $this->user->full_name,$setting['body']);
        $setting['body'] = str_replace('{{otp}}',(is_null(hyphenate($this->token)) || empty(hyphenate($this->token))) ? 'Unknown': hyphenate($this->token),$setting['body']);
        $setting['body'] = str_replace('{{otp_expire_duration}}',$otpDuration,$setting['body']);

        return $this
            ->from($setting['from'], $setting['from_name'])
            ->subject($setting['subject'])
            ->html( $setting['body']);
    }

    public function getSetting() : array
    {
        try {
            return getEmailAndTextSetting('CHANGE_TRANSACTION_PASSWORD_EMAIL_OTP');
        } catch (\Throwable $exception) {
            Log::error('TransactionPasswordOTP email error for getSetting CHANGE_TRANSACTION_PASSWORD_EMAIL_OTP');
            $setting = EmailContentSetting::query()->whereKey('CHANGE_TRANSACTION_PASSWORD_EMAIL_OTP')->first();
            return  $setting->toArray();
        }
    }
}
