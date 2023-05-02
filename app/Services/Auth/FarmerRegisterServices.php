<?php

namespace App\Services\Auth;

use App\Events\FarmerRegistered;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Auth\Farmer\ChangePhoneNumberRequest;
use App\Http\Requests\Auth\Farmer\RegisterVerifyOTPRequest;
use App\Http\Requests\Auth\Farmer\StoreKycRequest;
use App\Http\Requests\Auth\Farmer\RegisterRequest;
use App\Http\Requests\EnrollFaceIdRequest;
use App\Models\FaceBiometric;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Crypt;
use Seshac\Otp\Otp;

class FarmerRegisterServices extends BaseController
{
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::updateOrCreate(['phone' => $request->phone], [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'email' => $request->email,
                'code' => \Str::random(30),
                'state_id' => $request->state_id,
                'local_government_id' => $request->local_government_id,
                'ward_id' => $request->ward_id,
                'user_type_id'=>3,
            ]
        );

        FarmerRegistered::dispatch($user);
        return $this->sendResponse($user, 'Registration successfully', $user->createToken('x-onboarding-token')->plainTextToken);
    }

    public function verifyOTP(RegisterVerifyOTPRequest $request): JsonResponse
    {
        $verify = Otp::setKey('farmer-reg')->validate(auth()->user()->id, $request->otp);
        return ($verify->status)
            ? $this->sendResponse($verify->message)
            : $this->sendError($verify->message);
    }

    public function resendOTP(): JsonResponse
    {
        $resend = Otp::setKey('farmer-reg')->generate(auth()->user()->id);
        return ($resend->status)
            ? $this->sendResponse($resend->message)
            : $this->sendError($resend->message);
    }

    public function changePhoneNumber(ChangePhoneNumberRequest $request): JsonResponse
    {
        $user = User::find(auth()->user()->id);
        $user->phone = $request->phone;
        $user->save();
        FarmerRegistered::dispatch($user);
        $user->tokens()->delete();
        return $this->sendResponse($user, 'Phone number changed successfully', $user->createToken('x-onboarding-token')->plainTextToken);
    }

    public function enrollFaceId(EnrollFaceIdRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        $data['is_flagged'] = 0;
        $face_data = FaceBiometric::create($data);
        $response = [
            'user'=>User::find(auth()->user()->id),
            'face'=>$face_data
        ];

        return $this->sendResponse($response, 'Face ID enrolled successfully');
    }

    public function updateKyc(StoreKycRequest $request)
    {
        $user = User::find(auth()->user()->id);
        $photo = $request->file('profile_photo');
        $imageName = time().'_'. $user->id .'.'.$photo->extension();
        $imagePath = public_path(). '/users/profile';
        $photo->move($imagePath, $imageName);
        $imageFullPath = $imagePath. '/'.$imageName;
        $user->profile_picture = $imageFullPath; //file path will come from bunny-cdn api
        $user->save();

        $save_biometric_data = FaceBiometric::updateOrCreate(['user_id'=>$user->id],[
           'user_id'=>$user->id,
            'bio_data'=>$request->biometric,
            'is_flagged'=>0
        ]);

        $save_biometric_data['profile_picture'] = $imageFullPath;
        return $this->sendResponse($save_biometric_data, 'KYC data updated has been uploaded successfully.');
    }

    private function uploadToBunny($data)
    {
        $client = new \GuzzleHttp\Client();

        $endpoint = "https://storage.bunnycdn.com/novelag/user/";
        $response = $client->request('PUT', $endpoint, [
            'headers' => [
                'AccessKey' => '14c331fd-53ef-4c23-9ecb-1211d6e9adfc9b9d7149-eebb-48a7-8a44-bcb755330d8a',
                'content-type' => 'application/octet-stream',
            ],
        ]);

        echo $response->getBody();
    }
}
