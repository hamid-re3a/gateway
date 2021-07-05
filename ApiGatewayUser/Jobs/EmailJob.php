<?php

namespace ApiGatewayUser\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class EmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var Mailable
     */
    private $email;
    private $email_address;

    /**
     * Create a new job instance.
     *
     * @param Mailable $email
     * @param string $email_address
     */
    public function __construct(Mailable $email, $email_address)
    {
        $this->email = $email;
        $this->email_address = $email_address;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email_address)->send($this->email);
    }
}
