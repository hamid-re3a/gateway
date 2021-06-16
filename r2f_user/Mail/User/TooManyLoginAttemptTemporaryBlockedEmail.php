<?php

namespace R2FUser\Mail\User;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TooManyLoginAttemptTemporaryBlockedEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    private $login_attempt;
    private $login_attempt_count;
    private $try_in;

    /**
     * Create a new message instance.
     *
     * @param $user
     * @param $login_attempt
     * @param $login_attempt_count
     * @param $try_in
     */
    public function __construct($user, $login_attempt,$login_attempt_count,$try_in)
    {
        $this->user = $user;
        $this->login_attempt = $login_attempt;
        $this->login_attempt_count = $login_attempt_count;
        $this->try_in = $try_in;
    }

    /**
     * Build the message.
     *
     * @return $this
     * @throws \Exception
     */
    public function build()
    {
        $setting = getEmailAndTextSetting('TOO_MANY_LOGIN_ATTEMPTS_TEMPORARY_BLOCK_EMAIL');

        $setting['body'] = str_replace('{{full_name}}', $this->user->full_name, $setting['body']);
        $setting['body'] = str_replace('{{country}}', $this->login_attempt->ip->country, $setting['body']);
        $setting['body'] = str_replace('{{city}}', $this->login_attempt->ip->city, $setting['body']);
        $setting['body'] = str_replace('{{ip}}', $this->login_attempt->ip->ip, $setting['body']);
        $setting['body'] = str_replace('{{browser}}', $this->login_attempt->agent->browser, $setting['body']);
        $setting['body'] = str_replace('{{platform}}', $this->login_attempt->agent->platform, $setting['body']);
        $setting['body'] = str_replace('{{status}}', $this->login_attempt->login_status_string, $setting['body']);
        $setting['body'] = str_replace('{{login_attempt_times}}', $this->login_attempt_count, $setting['body']);
        $setting['body'] = str_replace('{{next_try_time}}', $this->try_in, $setting['body']);

        return $this
            ->from($setting['from'], $setting['from_name'])
            ->subject($setting['subject'])
            ->html($setting['body']);
    }


}
