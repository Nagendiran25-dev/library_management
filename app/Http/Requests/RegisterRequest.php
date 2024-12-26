<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:50',          // Name is required, must be a string, and max 50 characters
            'email' => [
                'required', 
                'email', 
                // Check uniqueness based on both email and role
                Rule::unique('users')->where(function ($query) {
                    return $query->where('role',$this->role); // Ensure role matches
                }),
            ],
            'password' => 'required|min:8|confirmed|regex:/[A-Z]/|regex:/[a-z]/|regex:/[0-9]/|regex:/[@$!%*?&]/', // Password is required, must be at least 8 characters, and confirmed
            'mobile_number' => 'nullable|numeric|digits:10',      // Phone is optional but if provided, must be a 10-digit number
        ];
    }
    /**
     * Get the custom error messages for validation failures.
     *
     * @return array
    */
    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'The email address is already in use.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.confirmed' => 'The password confirmation does not match.',
            'password.regex' => 'The password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
            'phone.digits' => 'The phone number must be 10 digits.',
        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'code'=>400,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ], 400));
    }
}
