<?php

namespace App\Http\Controllers;

class Base extends Controller
{
    public function sendResponse($result, $message)
    {
        $response = [
            'status' => true,
            'data' => $result,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }

    public function sendError($error, $messageError = [], $codeError = 404)
    {
        $response = [
            'status' => false,
            'data' => $error,
        ];
        if (!empty($messageError)) {
            $response['data'] = $messageError;
        }

        return response()->json($response, 404);
    }
}
