<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Comment;
use App\Classes\Response as apiResponse;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        try {
            $comments = Comment::all();
            return apiResponse::success(201, $comments);
        } catch (QueryException $exception) {
            $message = "Comments could not be fetched at this time";
            return apiResponse::error(503, null, $message);
        }
    }

    public function create(Request $request)
    {
        try {
            $comment = new Comment();
            $comment->comment = $request->comment;
            $comment->post_id = $request->post_id;
            $comment->save();
            return apiResponse::success(201, null);
        } catch (QueryException $exception) {
            return response([
                "status" => "error",
                "message" => $exception->getMessage(),
                "data" => null
            ], 503);
        }
    }
}
