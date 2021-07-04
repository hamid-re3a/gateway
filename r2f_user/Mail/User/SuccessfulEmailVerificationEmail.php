<?php

namespace R2FUser\Mail\User;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SuccessfulEmailVerificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    private $ip_db;
    private $agent_db;

    /**
     * Create a new message instance.
     *
     * @param $user
     * @param $ip_db
     * @param $agent_db
     */
    public function __construct($user, $ip_db, $agent_db)
    {
        $this->user = $user;
        $this->ip_db = $ip_db;
        $this->agent_db = $agent_db;
    }

    /**
     * Build the message.
     *
     * @return $this
     * @throws \Exception
     */
    public function build()
    {
        $setting = getEmailAndTextSetting('EMAIL_VERIFICATION_SUCCESS_EMAIL');

        $setting['body'] = str_replace('{{full_name}}', $this->user->full_name, $setting['body']);
        $setting['body'] = str_replace('{{country}}', $this->ip_db->country, $setting['body']);
        $setting['body'] = str_replace('{{city}}', $this->ip_db->city, $setting['body']);
        $setting['body'] = str_replace('{{ip}}', $this->ip_db->ip, $setting['body']);
        $setting['body'] = str_replace('{{browser}}', $this->agent_db->browser, $setting['body']);
        $setting['body'] = str_replace('{{platform}}', $this->agent_db->platform, $setting['body']);

        return $this
            ->from($setting['from'], $setting['from_name'])
            ->subject($setting['subject'])
            ->html($setting['body']);
    }


}