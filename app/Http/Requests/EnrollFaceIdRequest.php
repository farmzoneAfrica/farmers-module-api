<?php

namespace App\Http\Requests;

use App\Models\FaceBiometric;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class EnrollFaceIdRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'user_code' => 'required|unique:'.FaceBiometric::class,
            'provider' => 'required',
            'facial_id' => 'required|unique:'.FaceBiometric::class,
            'date_enrolled' => 'required',
            'gender' => 'required',
            'age' => 'required',
            'bio_data' => 'required',
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
