<?php
namespace App\Http\Controllers;

use App\Http\Controllers\BaseController as BaseController;
use App\Models\SurveyAnswer;
use App\Models\UserSurveyStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class SurveyAnswerController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'answers'               => 'required|array|min:1',
            'answers.*.question_id' => 'required|exists:survey_questions,id',
            'answers.*.answer'      => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors()->all(), 422);
        }

        $user = Auth::user();

        foreach ($request->answers as $answerData) {
            $answerValue = is_array($answerData['answer'])
            ? json_encode($answerData['answer'], JSON_UNESCAPED_UNICODE)
            : $answerData['answer'];

            SurveyAnswer::updateOrCreate(
                [
                    'user_id'     => $user->id,
                    'question_id' => $answerData['question_id'],
                ],
                [
                    'answer' => $answerValue,
                ]
            );
        }

        UserSurveyStatus::updateOrCreate(
            ['user_id' => $user->id],
            [
                'is_completed' => true,
                'completed_at' => now(),
            ]
        );

        $response = [
            'status'  => 'success',
            'code'    => 200,
            'message' => 'Successful conection.',
            'result'  => [
                'status'  => 'success',
                'code'    => 200,
                'message' => 'Answers saved successfully.',
            ],
        ];

        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(SurveyAnswer $surveyAnswer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SurveyAnswer $surveyAnswer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SurveyAnswer $surveyAnswer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SurveyAnswer $surveyAnswer)
    {
        //
    }

    /**
     * Display the authenticated user's survey answers.
     */
    public function showMyAnswers(Request $request)
    {
        $user = Auth::user();

        // Load answers with related question descriptions
        $answers = SurveyAnswer::where('user_id', $user->id)
            ->join('survey_questions', 'survey_answers.question_id', '=', 'survey_questions.id')
            ->select(
                'survey_answers.id',
                'survey_answers.question_id',
                'survey_questions.description as question_description',
                'survey_answers.answer'
            )
            ->get();

        // Format the response
        $formattedAnswers = $answers->map(function ($answer) {
            return [
                'id'                   => $answer->id,
                'question_id'          => $answer->question_id,
                'question_description' => $answer->question_description,
                'answer'               => $answer->answer,
            ];
        });

        // Load survey status
        $surveyStatus = UserSurveyStatus::where('user_id', $user->id)->first();

        $response = [
            'status'  => 'success',
            'code'    => 200,
            'message' => 'Successful conection.',
            'result'  => [
                'code'                => 200,
                'survey_completed'    => $surveyStatus?->is_completed ?? false,
                'survey_completed_at' => $surveyStatus?->completed_at?->toDateTimeString(),
                'answers'             => $formattedAnswers,
            ],
        ];
        return response()->json($response, 200);
    }
}
