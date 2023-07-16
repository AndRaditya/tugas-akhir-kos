<?php

namespace App\Events;

use App\Models\KosBooking;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\User;

class SendInvoice
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(KosBooking $kosBooking, User $user, $nomor_kamar)
    {
        $this->kosBooking = $kosBooking;
        $this->user = $user;
        $this->nomor_kamar = $nomor_kamar;
    }

}