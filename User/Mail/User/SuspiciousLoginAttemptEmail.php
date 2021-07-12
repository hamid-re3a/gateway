<?php

namespace User\Mail\User;

use User\Mail\SettingableMail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SuspiciousLoginAttemptEmail extends Mailable implements SettingableMail
{
    use Queueable, SerializesModels;

    public $user;
    private $login_attempt;

    /**
     * Create a new message instance.
     *
     * @param $user
     * @param $login_attempt
     */
    public function __construct($user, $login_attempt)
    {
        $this->user = $user;
        $this->login_attempt = $login_attempt;
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

        $setting['body'] = str_replace('{{full_name}}', $this->user->full_name, $setting['body']);
        $setting['body'] = str_replace('{{country}}', $this->login_attempt->ip->country, $setting['body']);
        $setting['body'] = str_replace('{{city}}', $this->login_attempt->ip->state_name, $setting['body']);
        $setting['body'] = str_replace('{{ip}}', $this->login_attempt->ip->ip, $setting['body']);
        $setting['body'] = str_replace('{{browser}}', $this->login_attempt->agent->browser, $setting['body']);
        $setting['body'] = str_replace('{{platform}}', $this->login_attempt->agent->platform, $setting['body']);
        $setting['body'] = str_replace('{{status}}', $this->login_attempt->login_status_string, $setting['body']);
        sleep(10);
        return $this
            ->from($setting['from'], $setting['from_name'])
            ->subject($setting['subject'])
            ->html($setting['body']);
    }


    public function getSetting(): array
    {
        return getEmailAndTextSetting('SUSPICIOUS_LOGIN_ATTEMPT_EMAIL') ;
    }
}
