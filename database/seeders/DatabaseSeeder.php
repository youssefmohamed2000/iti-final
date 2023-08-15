<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Book;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'a@a.com',
            'is_admin' => true,
        ]);

        User::factory(10)->create();
        Book::factory(50)->create();
        for ($i = 1; $i <= 50; $i++) {
            Book::factory()->create([
                'user_id' => rand(2, 10),
                'return_date' => Carbon::today()->addDays(rand(1, 29))
                    ->format('Y-m-d'),
            ]);
        }
    }
}
