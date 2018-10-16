<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Comment;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        try {
            $comments = Comment::all();
        } catch (QueryException $exception) {
            return response([
                "status" => "error",
                "message" => "Comments could not be fetched at this time",
                "data" => null
            ], 503);
        }
        return response()->json([
            "status" => "success",
            "data" => $comments
        ], 201);
    }
}
