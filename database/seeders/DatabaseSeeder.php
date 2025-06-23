<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Author;
use App\Models\Book;
use App\Models\Borrow;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Author::factory()->count(10)->create();
        Category::factory()->count(5)->create();
        User::factory()->count(20)->create();

        Book::factory()->count(50)->create();

        Borrow::factory()->count(100)->create();
    }
}
