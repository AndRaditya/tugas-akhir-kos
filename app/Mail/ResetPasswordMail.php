<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;


    public $user;
    public $plainPassword;
    public $url;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $plainPassword, $url)
    {
        $this->user = $user;
        $this->plainPassword = $plainPassword;
        $this->url = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('ResetPassword');
    }
}