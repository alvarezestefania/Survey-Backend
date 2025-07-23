<?php
namespace Database\Factories;

use App\Enums\QuestionType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SurveyQuestion>
 */
class SurveyQuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'description' => fake()->unique()->sentence(),
            'type'        => fake()->randomElement(array_column(QuestionType::cases(), 'value')),
            'options' => json_encode($this->faker->words(3)),
        ];
    }

    /**
     * Generate options for questions that require them.
     *
     * @return array|null
     */
    private function generateOptions(): ?array
    {
        return fake()->boolean(70) ? fake()->words(4) : null;
    }

    /**
     * Indicate that the question has specific options.
     *
     * @param array $options
     * @return static
     */
    public function withOptions(array $options): static
    {
        return $this->state(fn(array $attributes) => [
            'options' => $options,
            'type'    => QuestionType::MultipleChoice->value,
        ]);
    }
}
