<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

abstract class Controller
{
    use AuthorizesRequests;

    public function apiResponse($status = 200, $data = [], $message = ''): JsonResponse
    {
        $response = [];

        if ($status === 200 || $status === 201) {
            $response = $data;
        } else {
            if ($data) {
                $response['errors'] = $data;
            }
        }
        if ($message) {
            $response['message'] = $message;
        }

        return response()->json($response, $status);
    }
}
