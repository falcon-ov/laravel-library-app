<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BookPolicy
{
    /**
     * Определить, может ли пользователь просматривать список книг.
     */
    public function viewAny(User $user): Response
    {
        return $user->hasRole('admin') || $user->hasRole('user')
            ? Response::allow()
            : Response::deny('Доступ запрещён: только администраторы и пользователи могут просматривать книги.');
    }

    /**
     * Определить, может ли пользователь просматривать книгу.
     */
    public function view(User $user, Book $book): Response
    {
        return $user->hasRole('admin') || $user->hasRole('user')
            ? Response::allow()
            : Response::deny('Доступ запрещён: только администраторы и пользователи могут просматривать книгу.');
    }

    /**
     * Определить, может ли пользователь создавать книги.
     */
    public function create(User $user): Response
    {
        return $user->hasRole('admin')
            ? Response::allow()
            : Response::deny('Доступ запрещён: только администраторы могут создавать книги.');
    }

    /**
     * Определить, может ли пользователь обновлять книгу.
     */
    public function update(User $user, Book $book): Response
    {
        return $user->hasRole('admin')
            ? Response::allow()
            : Response::deny('Доступ запрещён: только администраторы могут обновлять книги.');
    }

    /**
     * Определить, может ли пользователь удалять книгу.
     */
    public function delete(User $user, Book $book): Response
    {
        return $user->hasRole('admin')
            ? Response::allow()
            : Response::deny('Доступ запрещён: только администраторы могут удалять книги.');
    }
}