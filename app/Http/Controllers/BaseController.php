<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function response($data, $message = 'success', $error_code = 0, $httpCode = 200)
    {
        return response()->json([
            'error_code' => $error_code,
            'message' => $message,
            'data' => $data
        ], $httpCode);
    }
}
