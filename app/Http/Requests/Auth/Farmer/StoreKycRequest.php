<?php

namespace App\Http\Requests\Auth\Farmer;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class StoreKycRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'profile_photo' => 'required|file|image|mimes:jpeg,png',
            'biometric' => 'required'
        ];
    }

    public function messages(): array
    {
        return [

        ];
    }

    public function attributes(): array
    {
        return [
            'profile_photo' => 'profile photo'
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
