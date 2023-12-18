<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class ApiController extends Controller
{
    /**
     * return success response
     *
     * @param array $data
     * @param string $message
     * @param integer $statusCode
     * @return JsonResponse
     */
    public function sendResponse(string $message, array $data, int $statusCode): JsonResponse
    {
        $response = [
            "success" => true,
            "statusCode" => $statusCode,
            'message' => $message,
            'data' => $data,
        ];

        return response()->json($response, $statusCode);
    }


    /**
     * return error response.
     *
     * @param string $error
     * @param array $errorMessages
     * @param integer $statusCode
     * @return JsonResponse
     */
    public function sendError(string $error, array $errorMessages = [], int $statusCode): JsonResponse
    {
        $response = [
            "success" => false,
            "statusCode" => $statusCode,
            "message" => $error,
            'errors' => $errorMessages
        ];

        return response()->json($response, $statusCode);
    }
}
