<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function jsonAnswer($message, $data = null, $error = null, $satisfactory = false, $statusCode = 500)
    {
        return response()->json([
            'satisfactory' => $satisfactory,
            'general_message' => $message,
            'data' => $data,
            'error' => $error,
        ], $statusCode);
    }
}
