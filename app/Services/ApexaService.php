<?php

namespace App\Services;


use App\Models\SentOtp;
use Illuminate\Support\Facades\Http;
use Seshac\Otp\Otp;

class ApexaService
{
    private int $log_id;
    private string $endpoint = 'https://apexa.com.ng/api/v2/otp/send';
    private string $apexa_token = 'APXGXLRVK1AEBAUILEY3JXRDOUHNLCUYRACGDKYIVMQ3OLNR1G';
    private string $otp;
    private string $phone;
    private string $reference;
    private string $template;


    public function __construct(string $otp, string $phone)
    {
        $this->otp = $otp;
        $this->phone = $phone;
        $this->generateReference();
        $this->getOtpTemplateCode();
    }

    private function generateReference(): void
    {
        $this->reference = 'NOVA-'.time().time();
    }

    private function getOtpTemplateCode(): void
    {
        $this->template = 2007538943;
    }

    private function log()
    {
        $log = SentOtp::create([
            'otp'=>$this->otp,
            'phone'=>$this->phone,
            'reference'=>$this->reference,
            'gateway'=>'apexa',
        ]);

        if (!$log) return false;
        $this->log_id = $log->id;
        return true;
    }

    private function updateLog(): bool
    {
        $log = SentOtp::find($this->log_id);
        if (!$log) return false;
        $log->status = 'sent';
        $log->save();
        return true;
    }

    public function send(): bool
    {
        $this->log();
        Http::post($this->endpoint, [
            'sender'=>'NOVEL-AG',
            'otp'=>$this->otp,
            'phone'=>$this->phone,
            'template'=>$this->template,
            'refid'=>$this->reference,
            'token'=>$this->apexa_token
        ]);
        $this->updateLog();
        return true;
    }


    public function retrieve()
    {

    }
}
