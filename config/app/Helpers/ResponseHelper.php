<?php

namespace App\Helpers;

use App\Helpers\LogHelper;

class ResponseHelper
{
    public static function success($data = [], int $statusCode = 200)
    {
        http_response_code($statusCode);
        echo json_encode([
            'success' => true,
            'response' => $data
        ]);
        exit;  // Terminate script to prevent further execution
    }

    public static function error($message = 'An error occurred', int $statusCode = 422)
    {
        //LogHelper::error($message);
        
        http_response_code($statusCode);
        echo json_encode([
            'success' => false,
            'error' => $message
        ]);
        exit;  // Terminate script to prevent further execution
    }
}
