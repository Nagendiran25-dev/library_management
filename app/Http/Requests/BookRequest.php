<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class BookRequest extends FormRequest
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
        $bookId = $this->route('book'); 
   
        return [
            'title' => [
                'required',
                'string',
                'min:10',
                'max:255',
                "unique:books,title,{$bookId},id"
            ],
            'author' => 'required|string|min:5|max:50',
            'description' => 'required|string|max:100',
            'published_date' => 'required|date_format:Y-m-d H:i',
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
            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a string.',
            'title.min' => 'The title must be at least 10 characters.',
            'title.max' => 'The title may not be greater than 255 characters.',
            'title.unique' => 'The title has already been taken.',

            'author.required' => 'The author field is required.',
            'author.string' => 'The author must be a string.',
            'author.min' => 'The author name must be at least 5 characters.',
            'author.max' => 'The author name may not be greater than 50 characters.',

            'description.required' => 'The description field is required.',
            'description.string' => 'The description must be a string.',
            'description.max' => 'The description may not be greater than 1000 characters.',

            'published_date.required' => 'The published date field is required.',
            'published_date.datetime' => 'The published date must be a valid datetime.',
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
