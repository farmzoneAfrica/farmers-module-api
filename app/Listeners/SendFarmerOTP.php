<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Http;
use Seshac\Otp\Otp;

class SendFarmerOTP
{
    private string $apexa_token = 'APXGXLRVK1AEBAUILEY3JXRDOUHNLCUYRACGDKYIVMQ3OLNR1G';
    /**
     * Handle the event.
     * @param object $event
     */
    public function handle(object $event): void
    {
        $user = $event->user;
        $otp = Otp::setKey('farmer-reg')->generate($user->id);
        //send OTP to phone number
        $request = [
            'sender'=>'NOVEL-AG',
            'otp'=>$otp->token,
            'phone'=>$user->phone,
            'template'=>2007538943,
            'refid'=>time().time(),
            'token'=>$this->apexa_token
        ];

        //$response = Http::post('http://apexa.com.ng/api/v2/otp/send', $request);
    }
}
