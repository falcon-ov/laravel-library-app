<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBookRequest extends FormRequest
{
    /**
     * Определить, авторизован ли пользователь для выполнения этого запроса.
     */
    public function authorize(): bool
    {
        return true; // Авторизация через BookPolicy
    }

    /**
     * Получить правила валидации для создания книги.
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'isbn' => ['required', 'string', 'max:13', Rule::unique('books', 'isbn')],
            'year' => ['required', 'integer', 'min:1000', 'max:' . date('Y')],
            'author_id' => ['required', 'integer', 'exists:authors,id'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
        ];
    }

    /**
     * Получить сообщения об ошибках для валидации.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Название книги обязательно.',
            'isbn.required' => 'ISBN обязателен.',
            'isbn.unique' => 'Этот ISBN уже используется.',
            'year.required' => 'Год издания обязателен.',
            'year.min' => 'Год издания должен быть не ранее 1000.',
            'year.max' => 'Год издания не может быть позже текущего года.',
            'author_id.exists' => 'Указанный автор не существует.',
            'category_id.exists' => 'Указанная категория не существует.',
        ];
    }
}