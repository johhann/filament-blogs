<?php

namespace Database\Factories;

use App\Enums\BlogStatus;
use App\Models\Author;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        $authors = collect(Author::pluck('id'));
        $categories = collect(Category::pluck('id'));

        return [
            'title' => $this->faker->sentence(4),
            'body' => $this->faker->text(),
            'status' => $this->faker->randomElement(BlogStatus::class),
            'published_at' => $this->faker->dateTime(),
            'category_id' => $categories->random(),
            'author_id' => $authors->random(),
        ];
    }
}
