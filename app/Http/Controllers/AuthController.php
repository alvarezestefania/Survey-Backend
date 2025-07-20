<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\UserSurveyStatus;

class AuthController extends BaseController
{
    public function signup(Request $request): JsonResponse
    {
        //
    }

    public function signin(Request $request): JsonResponse
    {
        //
    }

    public function signout()
    {
        //
    }

    /**
     * Display the authenticated user's information along with survey status.
     */
    public function currentUser(Request $request)
    {
       //
    }
}
