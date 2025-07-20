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
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string',
            'email'     => 'required|string|email|unique:users,email',
            'password'  => 'required|string|min:4|confirmed',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors()->all(), 401);
        }
        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
        ]);
        $fullToken = $user->createToken('user-token')->plainTextToken;
        $token = explode('|', $fullToken)[1];
        return $this->sendResponse([], 'User signup succesful.');
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
