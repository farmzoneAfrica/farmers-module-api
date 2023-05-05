<?php

namespace App\Listeners;

use App\Services\ApexaService;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Support\Facades\Http;
use Seshac\Otp\Otp;

class SendFarmerOTP
{
    public function handle(object $event): void
    {
        $user = $event->user;
        $apexa = new ApexaService(Otp::setKey('farmer-reg')->generate($user->id)->token, $user->phone);
        $apexa->send();
    }
}
