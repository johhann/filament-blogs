<?php

namespace Database\Factories;

use App\Models\Blog;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $blogs = collect(Blog::pluck('id'));
        $users = collect(User::pluck('id'));

        return [
            'body' => $this->faker->text(),
            'blog_id' => $blogs->random(),
            'user_id' => $users->random(),
        ];
    }
}
