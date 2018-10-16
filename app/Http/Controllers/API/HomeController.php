<?php

namespace App\Http\Controllers\API;

use Illuminate\Database\QueryException;
use App\Http\Controllers\Controller;
use App\Post;
use App\Classes\Response as apiResponse;

class HomeController extends Controller
{
    public function index()
    {
        try {
            $data = Post::with('comments')->get();
        } catch (QueryException $exception) {
            $message = "Posts could not be fetched at this time";
            return apiResponse::error(null, 503, $message);
        }
        return apiResponse::success(200, $data);
    }
}
