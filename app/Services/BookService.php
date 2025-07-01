<?php

namespace App\Services;

use App\Models\Book;
use Illuminate\Support\Facades\DB;

class BookService
{
    /**
     * Create a new book using a transaction.
     */
    public function create(array $data): Book
    {
        return DB::transaction(function () use ($data) {
            $book = Book::create($data);
            return $book->load(['author', 'category']);
        });
    }

    /**
     * Update an existing book using a transaction.
     */
    public function update(Book $book, array $data): Book
    {
        return DB::transaction(function () use ($book, $data) {
            $book->update($data);
            return $book->fresh()->load(['author', 'category']);
        });
    }
}
