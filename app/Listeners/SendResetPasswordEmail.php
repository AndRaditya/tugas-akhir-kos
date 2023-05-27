<?php

namespace App\Listeners;

use App\Events\ForgotPassword;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\ResetPassword;
use App\Mail\ResetPasswordMail;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Mail;
use Illuminate\Support\Facades\Hash;
use PharIo\Manifest\Url;

class SendResetPasswordEmail
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;

    }

    public function handle(ForgotPassword $event)
    {
        ResetPassword::where('email',$event->user->email)->delete();
        $plainPassword = Str::random(10);
        $hashPassword = Hash::make($plainPassword);
        
        $resetPassword = new ResetPassword([
            'email' => $event->user->email,
            'password' =>  $hashPassword
        ]);

        $this->userService->update($event->user->id, [
            'password' => $hashPassword,
        ]);
        $resetPassword->save();
        if(env('APP_ENV') == 'local'){
            $url = env('app_url') . ':8082';
        }else{
            $url = 'https://kost-catleya.space/#';
        }

        Mail::to($event->user->email)->send(new ResetPasswordMail($event->user, $plainPassword, $url));
    }

}