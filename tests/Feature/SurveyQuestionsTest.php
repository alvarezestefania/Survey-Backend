<?php
namespace Tests\Feature;

use App\Models\SurveyQuestion;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SurveyQuestionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_successful_get_questions(): void
    {
        // ARRANGE -----------------------------------------------------------------------
        $user = User::factory()->create();
        $this->actingAs($user);

        $question1 = SurveyQuestion::factory()->create([
            'description' => '¿Con qué frecuencia realiza control de inventario en su droguería?',
            'type'        => 'radio',
            'options'     => json_encode(['A diario', 'Semanalmente', 'Quincenalmente', 'Rara vez']),
        ]);
        $question2 = SurveyQuestion::factory()->create([
            'description' => '¿Cuál considera que es el mayor reto en su labor diaria dentro de la droguería?',
            'type'        => 'text',
            'options'     => null,
        ]);

        // ACT ---------------------------------------------------------------------------
        $response = $this->getJson('/api/questions');

        // ASSERT --------------------------------------------------------------------------
        $response->assertStatus(200)
            ->assertJson([
                'status'  => 'success',
                'code'    => 200,
                'message' => 'Successful connection.',
                'result'  => [
                    [
                        'id'          => $question1->id,
                        'description' => '¿Con qué frecuencia realiza control de inventario en su droguería?',
                        'type'        => 'radio',
                        'options'     => json_encode(['A diario', 'Semanalmente', 'Quincenalmente', 'Rara vez']),
                    ],
                    [
                        'id'          => $question2->id,
                        'description' => '¿Cuál considera que es el mayor reto en su labor diaria dentro de la droguería?',
                        'type'        => 'text',
                        'options'     => null,
                    ],
                ],
            ]);

        $this->assertDatabaseHas('survey_questions', [
            'id'          => $question1->id,
            'description' => '¿Con qué frecuencia realiza control de inventario en su droguería?',
        ]);

        $this->assertDatabaseHas('survey_questions', [
            'id'          => $question2->id,
            'description' => '¿Cuál considera que es el mayor reto en su labor diaria dentro de la droguería?',
        ]);
    }

    public function test_successful_get_empty_questions(): void
    {
        // ARRANGE -----------------------------------------------------------------------
        $user = User::factory()->create();
        $this->actingAs($user);

        // ACT ---------------------------------------------------------------------------
        $response = $this->getJson('/api/questions');

        // ASSERT --------------------------------------------------------------------------
        $response->assertStatus(200)
            ->assertJson([
                'status'  => 'success',
                'code'    => 200,
                'message' => 'Successful connection.',
                'result'  => [],
            ]);

        $this->assertDatabaseCount('survey_questions', 0);
    }
}
