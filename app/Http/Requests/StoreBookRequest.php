<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Authorization handled by BookPolicy
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'isbn' => [
                'required',
                'string',
                'max:13',
                Rule::unique('books', 'isbn'),
                'regex:/^(?=(?:\D*\d){10}(?:(?:\D*\d){3})?$)[\d-]+$/' // Проверка ISBN-10 или ISBN-13
            ],
            'year' => ['required', 'integer', 'min:1000', 'max:' . date('Y')],
            'author_id' => ['required', 'integer', 'exists:authors,id'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Book title is required.',
            'isbn.required' => 'ISBN is required.',
            'isbn.unique' => 'This ISBN is already in use.',
            'isbn.regex' => 'ISBN must be a valid ISBN-10 or ISBN-13 format.',
            'year.required' => 'Publication year is required.',
            'year.min' => 'Publication year must be 1000 or later.',
            'year.max' => 'Publication year cannot be later than the current year.',
            'author_id.exists' => 'The specified author does not exist.',
            'category_id.exists' => 'The specified category does not exist.',
        ];
    }
}
