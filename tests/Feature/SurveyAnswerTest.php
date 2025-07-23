<?php
namespace Tests\Feature;

use App\Models\SurveyAnswer;
use App\Models\SurveyQuestion;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SurveyAnswerTest extends TestCase
{

    use RefreshDatabase;

    public function test_successful_create_answer()
    {
        // ARRANGE ----------------------------------------------------------------------

        $user = User::factory()->create();
        $this->actingAs($user);

        $question1 = SurveyQuestion::factory()->create();
        $question2 = SurveyQuestion::factory()->create();

        $payload = [
            'answers' => [
                [
                    'question_id' => $question1->id,
                    'answer'      => 'Medellín',
                ],
                [
                    'question_id' => $question2->id,
                    'answer'      => [
                        'Hojas de cálculo (Excel, Google Sheets)',
                        'Registros físicos (cuadernos, libretas)',
                    ],
                ],
            ],
        ];

        // ACT --------------------------------------------------------------------------
        $response = $this->postJson('/api/answers', $payload);

        // ASSERT -----------------------------------------------------------------------
        $response->assertStatus(200)
            ->assertJson([
                'status'  => 'success',
                'code'    => 200,
                'message' => 'Successful connection.',
                'result'  => [
                    'status'  => 'success',
                    'code'    => 200,
                    'message' => 'Answers saved successfully.',
                ],
            ]);

        $this->assertDatabaseHas('survey_answers', [
            'user_id'     => $user->id,
            'question_id' => $question1->id,
            'answer'      => 'Medellín',
        ]);

        $this->assertDatabaseHas('survey_answers', [
            'user_id'     => $user->id,
            'question_id' => $question2->id,
            'answer'      => json_encode([
                'Hojas de cálculo (Excel, Google Sheets)',
                'Registros físicos (cuadernos, libretas)',
            ], JSON_UNESCAPED_UNICODE),
        ]);

        $this->assertDatabaseHas('user_survey_statuses', [
            'user_id'      => $user->id,
            'is_completed' => true,
        ]);
    }

    public function test_store_answer_validation_error(): void
    {
        // ARRANGE ----------------------------------------------------------------------
        $user = User::factory()->create();
        $this->actingAs($user);

        // ACT --------------------------------------------------------------------------
        $response = $this->postJson('/api/answers', []);

        // ASSERT -----------------------------------------------------------------------
        $response->assertStatus(422)
            ->assertJsonStructure([
                'status',
                'message',
                'errors',
            ]);
    }

    /**
     * Test validation error with invalid question_id
     */
    public function test_store_answer_invalid_question_error(): void
    {
        // ARRANGE ----------------------------------------------------------------------
        $user = User::factory()->create();
        $this->actingAs($user);

        $payload = [
            'answers' => [
                [
                    'question_id' => 999,
                    'answer'      => 'Medellín',
                ],
            ],
        ];

        // ACT --------------------------------------------------------------------------
        $response = $this->postJson('/api/answers', $payload);

        // ASSERT -----------------------------------------------------------------------
        $response->assertStatus(422)
            ->assertJsonStructure([
                'status',
                'message',
                'errors',
            ]);
    }


    public function test_store_answer_unauthenticated_error(): void
    {
        // ACT --------------------------------------------------------------------------
        $response = $this->postJson('/api/answers', [
            'answers' => [
                ['question_id' => 1, 'answer' => 'Medellín'],
            ],
        ]);

        // ASSERT ----------------------------------------------------------------------
        $response->assertStatus(401);
    }

    /**
     * Test answer update (overwrite existing)
     */
    public function test_successful_store_answer_update_existing(): void
    {
        // ARRANGE ----------------------------------------------------------------------
        $user = User::factory()->create();
        $this->actingAs($user);

        $question = SurveyQuestion::factory()->create();

        SurveyAnswer::create([
            'user_id'     => $user->id,
            'question_id' => $question->id,
            'answer'      => 'Old answer',
        ]);

        $payload = [
            'answers' => [
                [
                    'question_id' => $question->id,
                    'answer'      => 'New answer',
                ],
            ],
        ];

        // ACT --------------------------------------------------------------------------
        $response = $this->postJson('/api/answers', $payload);

        // ASSERT ------------------------------------------------------------------------
        $response->assertStatus(200)
            ->assertJson([
                'status'  => 'success',
                'code'    => 200,
                'message' => 'Successful connection.',
                'result'  => [
                    'status'  => 'success',
                    'code'    => 200,
                    'message' => 'Answers saved successfully.',
                ],
            ]);

        // Answer was updated, not duplicated
        $this->assertDatabaseHas('survey_answers', [
            'user_id'     => $user->id,
            'question_id' => $question->id,
            'answer'      => 'New answer',
        ]);

        $this->assertDatabaseMissing('survey_answers', [
            'user_id'     => $user->id,
            'question_id' => $question->id,
            'answer'      => 'Old answer',
        ]);

        // Only one answer exists
        $this->assertEquals(1, SurveyAnswer::where('user_id', $user->id)->count());
    }


}
