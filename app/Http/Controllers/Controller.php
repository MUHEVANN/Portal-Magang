<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


    public function successMessage($data, $message)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], 200);
    }

    public function errorMessage($message, $errorMessage = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        !empty($errorMessage) ? $response['data'] = $errorMessage : [];

        return response()->json($response, $code);
    }
}
