<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendContact extends Mailable
{
    use Queueable, SerializesModels;

    private $email;
    private $text;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $text)
    {
        $this->email = $email;
        $this->text = $text;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.contact', ['email' => $this->email, 'text' => $this->text]);
    }
}
