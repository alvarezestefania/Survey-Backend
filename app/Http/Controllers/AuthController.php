<?php
namespace App\Http\Controllers;

use App\Http\Controllers\BaseController as BaseController;
use App\Models\User;
use App\Models\UserSurveyStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;

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
        if (! Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return $this->sendError('Invalid Credentials.', ['Email or password are incorrect.'], 401);
        }

        $user         = Auth::user();
        $surveyStatus = UserSurveyStatus::where('user_id', $user->id)->first();

        $fullToken = $user->createToken('MyApp')->plainTextToken;
        $token     = explode('|', $fullToken)[1];
        $expiresAt = now()->addHour();

        $user->tokens()->latest()->first()->update([
            'expires_at' => $expiresAt,
        ]);

        $data = [
            'token'               => $token,
            'expires_at'          => $expiresAt->toDateTimeString(),
            'name'                => $user->name,
            'email'               => $user->email,
            'avatar'              => $user->avatar,
            'survey_completed'    => $surveyStatus?->is_completed ?? false,
            'survey_completed_at' => $surveyStatus?->completed_at,
        ];

        return $this->sendResponse($data, 'User signin successful Signin.');
    }

    public function signout()
    {
        Auth::user()->tokens->each(function ($token) {
            $token->forceDelete();
        });

        $response = [
            'status'  => 'success',
            'code'    => 200,
            'message' => 'Successful conection.',
            'result'  => [
                'status'  => 'success',
                'code'    => 200,
                'message' => 'Session closed.',
            ],
        ];
        
        return response()->json($response, 200);
    }

}
