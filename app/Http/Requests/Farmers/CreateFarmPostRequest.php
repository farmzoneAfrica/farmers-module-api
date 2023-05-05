<?php

namespace App\Http\Requests\Farmers;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class CreateFarmPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'crops' => 'required|array',
            'name' => 'required|string|min:5',
            'location_address'=>'required|string',
            'longitude' => 'required|string',
            'latitude' => 'required|string',
            'landmark' => '',
            'size' => 'required',
            'size_unit' => 'required|exists:farm_size_units,id|integer',
            'status' => 'required'
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
