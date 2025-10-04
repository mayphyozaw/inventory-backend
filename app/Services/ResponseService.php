<?php

namespace App\Services;

class ResponseService
{
    
    public static function success($data, $message = 'success')
    {
        return response()->json([
            'data' => $data,
            'message' => $message
        ], 200);
    }
    
    public static function fail($message = 'success')
    {
        return response()->json([
            'message'=> $message
        ], 422);
    }
}