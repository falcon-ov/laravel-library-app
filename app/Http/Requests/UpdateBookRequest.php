<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Authorization handled by BookPolicy
    }

    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'string', 'max:255'],
            'isbn' => [
                'sometimes',
                'string',
                'max:13',
                Rule::unique('books', 'isbn')->ignore($this->book),
                'regex:/^(?=(?:\D*\d){10}(?:(?:\D*\d){3})?$)[\d-]+$/' // Проверка ISBN
            ],
            'year' => ['sometimes', 'integer', 'min:1000', 'max:' . date('Y')],
            'author_id' => ['sometimes', 'integer', 'exists:authors,id'],
            'category_id' => ['sometimes', 'integer', 'exists:categories,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.max' => 'Book title must not exceed 255 characters.',
            'isbn.unique' => 'This ISBN is already in use.',
            'isbn.regex' => 'ISBN must be a valid ISBN-10 or ISBN-13 format.',
            'year.min' => 'Publication year must be 1000 or later.',
            'year.max' => 'Publication year cannot be later than the current year.',
            'author_id.exists' => 'The specified author does not exist.',
            'category_id.exists' => 'The specified category does not exist.',
        ];
    }
}
