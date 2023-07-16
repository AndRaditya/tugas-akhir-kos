<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InvoicePesananMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $kosBooking;
    public $tanggal;
    public $nomor_kamar;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $kosBooking, $tanggal, $nomor_kamar)
    {
        $this->user = $user;
        $this->kosBooking = $kosBooking;
        $this->tanggal = $tanggal;
        $this->nomor_kamar = $nomor_kamar;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('InvoicePesananConfirm');
    }
}