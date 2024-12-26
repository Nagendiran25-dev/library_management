<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class BookBorrowRequest extends FormRequest
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
            'book_id' => [
                'required',
                'integer',
                function ($attribute, $value, $fail) {
                    $bookExists = DB::table('books')
                        ->where('id', $value)
                        ->exists();

                    if (!$bookExists) {
                        $fail('The selected book does not exist.');
                    }
                    if($this->type=='borrow')
                    {
                        $isAvailable = DB::table('books')
                            ->where('id', $value)
                            ->where('status', 0)  // Check if the book is available
                            ->exists();
                        if(!$isAvailable)
                        {
                            $fail('The selected book is currently not available for borrowing.');
                        }
                    }
                }
            ],
            'user_id' => [
                'required',
                'integer',
                function ($attribute, $value, $fail) {
                    // Check if the user exists
                    $userExists = DB::table('users')->where([
                        ['id', '=', $value],
                        ['role', '=', 'user']
                    ])->exists();
                    if (!$userExists) {
                        $fail('The user does not exist.');
                    }
                }
            ],
            'borrowed_id' => [
                'integer',
                function ($attribute, $value, $fail) {
                    // Check if the route parameter 'type' is 'return'
                    $type = $this->type;
                  
                    if ($type == 'return' && empty($value)) {
                        $fail('The borrowed_id field is required when type is return.');
                    }
                    // If borrowed_id is provided, validate its existence
                    if ($value) {
                        $borrowedExists = DB::table('borrowed_books')
                            ->where('id', $value)
                            ->exists();
    
                        if (!$borrowedExists) {
                            $fail('The selected borrowed ID does not exist.');
                        }
                    }
                    // Check if the borrowed book has already been returned
                    if ($value) {
                        $borrowedExists = DB::table('borrowed_books')
                            ->where('id', $value)
                            ->where('status', 0) // Check if the book's status is 0 (returned)
                            ->exists();

                        if ($borrowedExists) {
                            $fail('The selected borrowed ID has already been returned.');
                        }
                    }
                }
            ],
            'fine_amount' => [
                'integer'
            ]
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
            'book_id.required' => 'Book ID is required.',
            'book_id.integer' => 'Book ID must be a valid integer.',
            'user_id.required' => 'User ID is required.',
            'user_id.integer' => 'User ID must be a valid integer.',
            "borrowed_id.required" => "The borrowed_id field is required when type is borrow.",
            'fine_amount.integer' => 'Fine Amount must be a valid integer.',
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
