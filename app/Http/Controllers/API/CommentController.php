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

    public function create(Request $request)
    {
//        $data = $request->all();
        try {
            $comment = new Comment();
            $comment->comment = $request->comment;
            $comment->post_id = $request->post_id;
            $comment->save();
        } catch (QueryException $exception) {
            return response([
                "status" => "error",
                "message" => $exception->getMessage(),
                "data" => null
            ], 503);
        }
        return response()->json([
            "status" => "success",
            "message" => "Thank you for your comment",
            "data" => null
        ], 201);
    }
}
