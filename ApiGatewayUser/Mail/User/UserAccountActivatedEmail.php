<?php

namespace ApiGatewayUser\Mail\User;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use ApiGatewayUser\Models\UserBlockHistory;

class UserAccountActivatedEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    private $user_block_history;
    private $login_attempt_count;
    private $try_in;

    /**
     * Create a new message instance.
     *
     * @param $user
     * @param $user_block_history
     * @param $login_attempt_count
     * @param $try_in
     */
    public function __construct($user, $user_block_history)
    {
        $this->user = $user;
        $this->user_block_history = $user_block_history;
    }

    /**
     * Build the message.
     *
     * @return $this
     * @throws \Exception
     */
    public function build()
    {
        if (is_null($this->user_block_history->block_type))
            $setting = getEmailAndTextSetting('USER_ACCOUNT_ACTIVATED_EMAIL');
        else
            $setting = getEmailAndTextSetting('USER_ACCOUNT_DEACTIVATED_EMAIL');

        $setting['body'] = str_replace('{{full_name}}', $this->user->full_name, $setting['body']);
        $setting['body'] = str_replace('{{block_type}}', $this->user_block_history->block_type, $setting['body']);
        $setting['body'] = str_replace('{{block_reason}}', $this->user_block_history->block_reason, $setting['body']);
        if (is_null($this->user_block_history->actor))
            $actor_name = '';
        else
            $actor_name = $this->user_block_history->actor->full_name;
        $setting['body'] = str_replace('{{actor_full_name}}', $actor_name, $setting['body']);

        return $this
            ->from($setting['from'], $setting['from_name'])
            ->subject($setting['subject'])
            ->html($setting['body']);
    }


}
