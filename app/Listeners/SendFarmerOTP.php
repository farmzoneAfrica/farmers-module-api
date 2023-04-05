<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Http;
use Seshac\Otp\Otp;

class SendFarmerOTP
{
    private string $apexa_token = 'APXGXLRVK1AEBAUILEY3JXRDOUHNLCUYRACGDKYIVMQ3OLNR1G';

    public function handle(object $event): void
    {
        $user = $event->user;

        $request = [];
        $request['sender'] = 'NOVEL-AG';
        $request['otp'] = Otp::setKey('farmer-reg')->generate($user->id)->token;
        $request['phone'] = $user->phone;
        $request['template'] = 2007538943;
        $request['refid'] = time().time();
        $request['token'] = $this->apexa_token;
        $response = Http::post('http://apexa.com.ng/api/v2/otp/send', $request);
    }
}
