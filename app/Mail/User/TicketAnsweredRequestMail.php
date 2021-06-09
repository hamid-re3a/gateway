<?php

namespace App\Mail\User;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketAnsweredRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $ticket_id;

    /**
     * Create a new message instance.
     *
     * @param $user
     * @param $ticket_id
     */
    public function __construct($user, $ticket_id)
    {
        $this->user = $user;
        $this->ticket_id = $ticket_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.ticket-answered')->subject('Ticket Answered');
    }
}
