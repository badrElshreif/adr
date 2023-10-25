<?php

namespace App\Admin\Domain\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $message;

    public $title;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($message, $title)
    {
        $this->message = $message;
        $this->title = $title;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->title)->markdown('emails.forget_password');
    }
}
