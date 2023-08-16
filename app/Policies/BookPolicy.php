<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BookPolicy
{
    public function create(User $user): bool
    {
        return $user->is_admin;
    }

    public function update(User $user, Book $book): bool
    {
        return $user->is_admin;
    }

    public function delete(User $user, Book $book): bool
    {
        return $user->is_admin;
    }
}
