<?php
namespace Tests\Feature;

use App\Models\SurveyAnswer;
use App\Models\SurveyQuestion;
use App\Models\User;
use App\Models\UserSurveyStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadAnswersTest extends TestCase
{
    use RefreshDatabase;

    public function test_successful_get_user_answers(): void
    {
        // ARRANGE ------------------------------------------------------------------------
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

        SurveyAnswer::create([
            'user_id'     => $user->id,
            'question_id' => $question1->id,
            'answer'      => 'Semanalmente',
        ]);

        SurveyAnswer::create([
            'user_id'     => $user->id,
            'question_id' => $question2->id,
            'answer'      => 'El inventario',
        ]);

        UserSurveyStatus::create([
            'user_id'      => $user->id,
            'is_completed' => true,
            'completed_at' => now(),
        ]);

        // ACT ---------------------------------------------------------------------------
        $response = $this->getJson('/api/my-answers');

        // ASSERT ------------------------------------------------------------------------
        $response->assertStatus(200)
            ->assertJson([
                'status'  => 'success',
                'code'    => 200,
                'message' => 'Successful connection.',
                'result'  => [
                    'code'                => 200,
                    'survey_completed'    => true,
                    'survey_completed_at' => now()->toDateTimeString(),
                    'answers'             => [
                        [
                            'id'                   => 1,
                            'question_id'          => $question1->id,
                            'question_description' => '¿Con qué frecuencia realiza control de inventario en su droguería?',
                            'answer'               => 'Semanalmente',
                        ],
                        [
                            'id'                   => 2,
                            'question_id'          => $question2->id,
                            'question_description' => '¿Cuál considera que es el mayor reto en su labor diaria dentro de la droguería?',
                            'answer'               => 'El inventario',
                        ],
                    ],
                ],
            ]);
    }

    public function test_successful_get_empty_answers(): void
    {
        // ARRANGE -----------------------------------------------------------------------
        $user = User::factory()->create();
        $this->actingAs($user);

        // ACT ---------------------------------------------------------------------------
        $response = $this->getJson('/api/my-answers');

        // ASSERT --------------------------------------------------------------------------
        $response->assertStatus(200)
            ->assertJson([
                'status'  => 'success',
                'code'    => 200,
                'message' => 'Successful connection.',
                'result'  => [
                    'code'                => 200,
                    'survey_completed'    => false,
                    'survey_completed_at' => null,
                    'answers'             => [],
                ],
            ]);

        $this->assertDatabaseMissing('survey_answers', [
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseMissing('user_survey_statuses', [
            'user_id' => $user->id,
        ]);
    }
}
