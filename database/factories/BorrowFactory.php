<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Book;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Borrow>
 */
class BorrowFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $borrowedAt = $this->faker->dateTimeBetween('-1 year', 'now');
        $returnedAt = $this->faker->boolean(70) ? $this->faker->dateTimeBetween($borrowedAt, 'now') : null;
        return [
            'book_id' => Book::inRandomOrder()->first()->id ?? Book::factory(),
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'borrowed_at' => $borrowedAt,
            'returned_at' => $returnedAt,
        ];
    }
}
