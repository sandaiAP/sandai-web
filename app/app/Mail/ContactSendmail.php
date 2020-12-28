<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactSendmail extends Mailable
{
    use Queueable, SerializesModels;

    private $email;
    private $name;
    private $body;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( $inputs )
    {
        $this->email = $inputs['email'];
        $this->name = $inputs['name'];
        $this->body  = $inputs['body'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from('kiddman777@gmail.com')
            ->subject('自動送信メール')
            ->view('contact.mail')
            ->with([
                'email' => $this->email,
                'name' => $this->name,
                'body'  => $this->body,
            ]);
    }
}
