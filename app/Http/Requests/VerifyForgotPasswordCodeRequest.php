<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class VerifyForgotPasswordCodeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'otp' => 'required|exists:otps,token'
        ];
    }

    public function messages(): array
    {
        return [
            'otp.required'=>'OTP is required.',
            'otp.exits'=>'Invalid OTP',
        ];
    }

    public function attributes(): array
    {
        return [

        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'validation-errors',
            'data'      => $validator->errors()->all()
        ], Response::HTTP_BAD_REQUEST));
    }
}
