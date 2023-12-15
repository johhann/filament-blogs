<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        User::updateOrCreate([
            'email' => 'admin@admin.com',
        ], [
            'name' => 'john Doe',
            'password' => bcrypt('password'),
            'status' => true,
        ]);

        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->safeEmail(),
            'password' => $this->faker->password(),
            'status' => $this->faker->boolean(),
        ];
    }
}
