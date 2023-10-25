<?php

namespace App\AppContent\Domain\Mail;

use App\AppContent\Domain\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PromotionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $message;

    public $fromAddress;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($message, $fromAddress)
    {
        $this->message = $message;
        $this->fromAddress = $fromAddress;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $setting = Setting::where('key', 'store_name')->first();
        $store_name_subj = $setting ? $setting->body : tenant()->id;
        $store_name = $setting ? $setting->value : tenant()->id;
        $url = 'http://'.tenant()->id.'.manssah.com:3009';

        return $this->subject($store_name_subj)->markdown('emails.promotion', [
            'url' => $url,
            'store_name' => $store_name,
        ]);

        // return $this->from($this->fromAddress)->subject($store_name_subj)->markdown('emails.promotion', [
        //             'url' => $url,
        //             'store_name' => $store_name,
        //         ]);

    }
}
