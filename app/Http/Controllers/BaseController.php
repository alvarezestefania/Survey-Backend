<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

/**
 * BaseController handles standardized JSON responses for success and error cases.
 */
class BaseController extends Controller
{
    /**
     * Send success response.
     *
     * @param mixed $data Response data
     * @param string $message Message to display.
     * @param int $code HTTP response code (default 200)
     * @return JsonResponse
     */
    public function sendResponse($data, $message, $code = 200): JsonResponse
    {
        return response()->json([
            'status'  => 'success',
            'code'    => 200,
            'message' => 'Successful connection',
            'result' => [
                'status'  => 'success',
                'code'    => $code,
                'message' => $message,
                'data'    => $data,
            ],
        ], 200);
    }

    /**
     * Send error response.
     *
     * @param string $message Error Message
     * @param array $errorMessages Additional errors (optional)
     * @param int $code Error code (default 400)
     * @return JsonResponse
     */
    public function sendError($message, $errorMessages = [], $code = 400): JsonResponse
    {
        return response()->json([
            'status'  => 'success',
            'code'    => 200,
            'message' => 'Successful connection',
            'result' => [
                'status'  => 'danger',
                'code'    => $code,
                'message' => is_array($errorMessages) ? implode(' ', $errorMessages) : $message,
            ],
        ], 200);
    }
}
