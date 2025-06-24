<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBookRequest extends FormRequest
{
    /**
     * Определить, авторизован ли пользователь для выполнения этого запроса.
     */
    public function authorize(): bool
    {
        return true; // Авторизация через BookPolicy
    }

    /**
     * Получить правила валидации для обновления книги.
     */
    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'string', 'max:255'],
            'isbn' => [
                'sometimes',
                'string',
                'max:13',
                Rule::unique('books', 'isbn')->ignore($this->book),
            ],
            'year' => ['sometimes', 'integer', 'min:1000', 'max:' . date('Y')],
            'author_id' => ['sometimes', 'integer', 'exists:authors,id'],
            'category_id' => ['sometimes', 'integer', 'exists:categories,id'],
        ];
    }

    /**
     * Получить сообщения об ошибках для валидации.
     */
    public function messages(): array
    {
        return [
            'title.max' => 'Название книги не должно превышать 255 символов.',
            'isbn.unique' => 'Этот ISBN уже используется.',
            'year.min' => 'Год издания должен быть не ранее 1000.',
            'year.max' => 'Год издания не может быть позже текущего года.',
            'author_id.exists' => 'Указанный автор не существует.',
            'category_id.exists' => 'Указанная категория не существует.',
        ];
    }
}