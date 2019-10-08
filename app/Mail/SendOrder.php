<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendOrder extends Mailable
{
    use Queueable, SerializesModels;

    private $id;
    private $name;
    private $phone;
    private $date;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($id, $name, $phone, $date)
    {
        $this->id = $id;
        $this->name = $name;
        $this->phone = $phone;
        $this->date = $date;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.order', ['id' => $this->id, 'name' => $this->name, 'phone' => $this->phone, 'date' => $this->date]);
    }
}
