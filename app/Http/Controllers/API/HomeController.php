<?php

namespace App\Http\Controllers\API;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Post;

class HomeController extends Controller
{
    public function index()
    {
        try {
            $data = Post::with('comments')->get();
        } catch (QueryException $exception) {
            return reponse()->json([
                "status" => "error",
                "message" => "Posts could not be fetched at this time",
                "data" => null
            ], 503);
        }
        return response()->json([
            "status" => "success",
            "data" => $data
        ]);
    }
}
