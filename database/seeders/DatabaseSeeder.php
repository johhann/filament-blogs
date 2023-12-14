<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();
        \App\Models\Category::factory(3)->create();
        \App\Models\Author::factory(10)->create();
        \App\Models\Blog::factory(50)->create();
        \App\Models\Comment::factory(100)->create();
    }
}
