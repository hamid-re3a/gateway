<?php

namespace App\Notifications\User;

use App\Mail\User\WelcomeEMail;
use App\Services\User\VerifyCodeService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomerAnsweredNotification extends Notification implements ShouldQueue
{
    use Queueable;


    private $ticket_id;

    public function __construct($ticket_id)
    {
        $this->ticket_id = $ticket_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }


    public function toMail($notifiable)
    {
        return (new WelcomeEMail($notifiable,$this->ticket_id))
            ->to($notifiable->email);

    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
