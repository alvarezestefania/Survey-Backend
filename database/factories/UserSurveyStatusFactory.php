<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserSurveyStatus>
 */
class UserSurveyStatusFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $isCompleted = fake()->boolean();

        return [
            'user_id' => User::factory(),
            'is_completed' => $isCompleted,
            'completed_at' => $isCompleted ? now() : null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }


    /**
     * Indicate that the survey status is completed.
     *
     * @return static
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_completed' => true,
            'completed_at' => now(),
        ]);
    }

    /**
     * Indicate that the survey status is not completed.
     *
     * @return static
     */
    public function incomplete(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_completed' => false,
            'completed_at' => null,
        ]);
    }
}
