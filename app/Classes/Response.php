<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16/10/2018
 * Time: 4:03 PM
 */

namespace App\Classes;


class Response
{
    public static function success($statusCode, $data = null, $message = null)
    {
        return response()->json([
            "status" => "success",
            "message" => $message,
            "data" => $data
        ], $statusCode);
    }

    public static function error($statusCode, $data, $message = null)
    {
        return response()->json([
            "status" => "error",
            "message" => $message,
            "data" => $data,
        ], $statusCode);
    }
}