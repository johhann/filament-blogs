<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Author;
use App\Models\Blog;
use App\Models\Category;

class BlogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Blog::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(4),
            'body' => $this->faker->text(),
            'status' => $this->faker->word(),
            'published_at' => $this->faker->dateTime(),
            'category_id' => Category::factory(),
            'author_id' => Author::factory(),
        ];
    }
}
