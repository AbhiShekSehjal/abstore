<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\admin\Setting;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $settings;

    public function __construct($data, Setting $settings)
    {
        $this->data = $data;
        $this->settings = $settings;
    }

    public function build()
    {
        return $this->from(
                        $this->settings->email ?? config('mail.from.address'),
                        $this->settings->site_name ?? config('mail.from.name')
                    )
                    ->replyTo($this->data['email'])
                    ->subject('New Contact Form Message')
                    ->view('emails.mail');
    }
}
