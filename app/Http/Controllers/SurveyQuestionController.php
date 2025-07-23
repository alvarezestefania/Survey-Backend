<?php
namespace App\Http\Controllers;

use App\Models\SurveyQuestion;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Http\Request;

class SurveyQuestionController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $answers  = SurveyQuestion::all();
        $response = [
            'status'  => 'success',
            'code'    => 200,
            'message' => 'Successful connection.',
            'result'  => $answers->toArray(),
        ];
        return response()->json($response, 200);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(SurveyQuestion $surveyQuestion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SurveyQuestion $surveyQuestion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SurveyQuestion $surveyQuestion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SurveyQuestion $surveyQuestion)
    {
        //
    }
}
