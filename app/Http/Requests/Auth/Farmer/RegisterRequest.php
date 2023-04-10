<?php

namespace App\Http\Requests\Auth\Farmer;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone' => ['required','string', 'max:255'],
            'email' => ['email','string', 'max:255'],
            //'state_id' => ['required','int', 'exists:states,id'],
            //'local_government_id' => ['required','int', 'exists:local_governments,id'],
            //'ward_id' => ['int', 'exists:wards,id'],
            'accept_terms'=>['required', 'int', Rule::in(1)]
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'First name is required',
            'last_name.required' => 'Last name is required',
            'email.required' => 'Email is required',
            'state_id.required' => 'Select a state.',
            'local_government_id.required' => 'Select a local government',
            'accept_terms.required' => 'Accept terms & conditions',
        ];
    }


    public function filters(): array
    {
        return [
            'email' => 'trim|lowercase',
            'first_name' => 'trim|capitalize|escape',
            'last_name' => 'trim|capitalize|escape',
        ];
    }

    public function attributes(): array
    {
        return [
            'email' => 'email address',
            'state_id'=>'state',
            'local_government_id'=>'local government',
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
