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

Route::post('/auth/signup', [AuthController::class, 'signup']);
Route::post('/auth/signin', [AuthController::class, 'signin']);
Route::get('/auth/signout', [AuthController::class, 'signout']);
Route::get('/auth/user', [AuthController::class, 'currentUser']);

Route::get('/questions', [SurveyQuestionController::class, 'index']);

Route::post('/answers', [SurveyAnswerController::class, 'create']);
Route::get('/my-answers', [SurveyAnswerController::class, 'showMyAnswers']);

