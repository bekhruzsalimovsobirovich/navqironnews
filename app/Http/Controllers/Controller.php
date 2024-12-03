<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * @param $message
     * @param $result
     * @param $code
     * @return JsonResponse
     */
    public function successResponse($message, $result = [], $code = 200)
    {
        $response = [
            'status' => true,
            'message' => $message,
            'data'    => $result
        ];
        return response()->json($response, $code);
    }

    /**
     * Error response method.
     *
     * @param $message
     * @param int $code
     * @return JsonResponse
     */
    public function errorResponse($message, int $code = 400): JsonResponse
    {
        $response = [
            'status' => false,
            'error'=>true,
            'message' => $message
        ];

        return response()->json($response, $code);
    }
}
