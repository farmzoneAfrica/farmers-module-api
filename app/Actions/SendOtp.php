<?php


namespace App\Actions;


use App\Models\User;
use Illuminate\Support\Facades\Http;

class SendOtp
{
    private string $apexa_token = 'APXGXLRVK1AEBAUILEY3JXRDOUHNLCUYRACGDKYIVMQ3OLNR1G';

    public function handle(User $user, string $otp, string $phone)
    {
        $request = [
            'sender'=>'NOVEL-AG',
            'otp'=>$otp,
            'phone'=>$phone,
            'template'=>'123456',
            'refid'=>'',
            'token'=>$this->apexa_token
        ];
        $response = Http::post('https://apexa.com.ng/api/v2/otp/send', $request);
        die(print_r($response));
    }
}
