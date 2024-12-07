<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::factory()->create([
            'name' => 'user',
            'email' => 'user@example.com',
            'is_admin' => false,
        ]);
        $user2 = User::factory()->create([
            'name' => 'user2',
            'email' => 'user2@example.com',
            'is_admin' => false,
        ]);
        $admin = User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'is_admin' => true,
        ]);

        Article::factory()->count(10)->for($user)->create();
    }
}
