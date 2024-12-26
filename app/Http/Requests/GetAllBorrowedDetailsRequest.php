<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class GetAllBorrowedDetailsRequest extends FormRequest
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
            'user_id' => 'nullable|integer|exists:users,id',
            'user_email' => 'nullable|email|exists:users,email',
            'due_date_from' => 'nullable|date_format:Y-m-d H:i',
            'due_date_to' => 'nullable|date_format:Y-m-d H:i|after_or_equal:due_date_from',
            'borrow_status' => 'nullable|string|in:0,1',
            'user_status' => 'nullable|string|in:0,1', 
            'return_date_from' => 'nullable|date_format:Y-m-d H:i',
            'return_date_to' => 'nullable|date_format:Y-m-d H:i|after_or_equal:return_date_from',
            'per_page' => 'required|integer|min:1',
            'page' => 'required|integer|min:1'
        ];
    }
    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'due_date_to.after_or_equal' => 'The due date to must be after or equal to the due date from.',
            'return_date_to.after_or_equal' => 'The return date to must be after or equal to the return date from.',
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
