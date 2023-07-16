<?php

namespace App\Listeners;

use App\Events\ForgotPassword;
use App\Events\SendInvoice;
use App\Mail\InvoicePesananMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\ResetPassword;
use App\Mail\ResetPasswordMail;
use App\Mail\SendInvoiceMail;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Carbon\Carbon;
use Mail;
use Illuminate\Support\Facades\Hash;
use PharIo\Manifest\Url;

class SendInvoiceEmail
{
    public function handle(SendInvoice $event)
    {
        $tanggal = Carbon::parse($event->kosBooking->date)->format('d M Y H:i:s');
        Mail::to($event->user->email)->send(new InvoicePesananMail($event->user, $event->kosBooking, $tanggal, $event->nomor_kamar[0]));
    }

}