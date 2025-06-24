<?php

namespace App\Services;

use App\Models\Book;
use Illuminate\Support\Facades\DB;
use Exception;

class BookService
{
    /**
     * Создать новую книгу с использованием транзакции.
     */
    public function create(array $data): Book
    {
        return DB::transaction(function () use ($data) {
            try {
                $book = Book::create($data);
                return $book;
            } catch (Exception $e) {
                throw new Exception('Не удалось создать книгу: ' . $e->getMessage());
            }
        });
    }

    /**
     * Обновить существующую книгу с использованием транзакции.
     */
    public function update(Book $book, array $data): Book
    {
        return DB::transaction(function () use ($book, $data) {
            try {
                $book->update($data);
                return $book->fresh();
            } catch (Exception $e) {
                throw new Exception('Не удалось обновить книгу: ' . $e->getMessage());
            }
        });
    }
}