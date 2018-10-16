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
    public function success($data, $statusCode)
    {
        return response()->json([
            "status" => "success",
            "data" => $data,
        ], $statusCode);
    }
}