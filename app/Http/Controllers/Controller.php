<?php

namespace App\Http\Controllers;

abstract class Controller
{

    public static function outputResponse($data = null, $message = "Success", $code = 200)
    {
        return response()->json([
            "status" => true,
            "code" => $code,
            "message" => $message,
            "data" => $data,
        ], $code);
    }

    public static function success($data = null, $message = "Success", $code = 200)
    {
        return response()->json([
            "status" => true,
            "code" => $code,
            "message" => $message,
            "data" => $data,
        ], $code);
    }

    public static function error($message = "Error", $errors = [], $code = 400)
    {
        return response()->json([
            "status" => false,
            "code" => $code,
            "message" => $message,
        ], $code);
    }
}
