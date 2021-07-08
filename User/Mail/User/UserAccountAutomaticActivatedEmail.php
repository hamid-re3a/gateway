<?php

namespace User\Mail\User;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use User\Mail\SettingableMail;

class UserAccountAutomaticActivatedEmail extends Mailable implements SettingableMail
{
    use Queueable, SerializesModels;

    public $user;

    /**
     * Create a new message instance.
     *
     * @param $user
     * @param $user_block_history
     * @param $login_attempt_count
     * @param $try_in
     */
    public function __construct($user)
    {
        $this->user = $user;
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

        return $this
            ->from($setting['from'], $setting['from_name'])
            ->subject($setting['subject'])
            ->html($setting['body']);
    }


    public function getSetting(): array
    {
        return getEmailAndTextSetting('USER_ACCOUNT_ACTIVATED_AUTOMATICALLY_EMAIL');
    }
}
