<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SurveyQuestionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Auth
Route::post('/auth/signup', [AuthController::class, 'signup']);
Route::post('/auth/signin', [AuthController::class, 'signin']);

Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('/auth/signout', [AuthController::class, 'signout']);

    // Survey
    Route::get('/questions', [SurveyQuestionController::class, 'index']);

    // Survey Answers
    Route::post('/answers', [SurveyAnswerController::class, 'create']);
    Route::get('/my-answers', [SurveyAnswerController::class, 'showMyAnswers']);

});
