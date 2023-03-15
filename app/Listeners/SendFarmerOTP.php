<?php

namespace App\Listeners;

use Seshac\Otp\Otp;

class SendFarmerOTP
{
    /**
     * Handle the event.
     * @param object $event
     */
    public function handle(object $event): void
    {
        $user = $event->user;
        Otp::setKey('farmer-reg')->generate($user->id);
        //send OTP to phone number
    }
}
