<?php

namespace App\Http\Controllers\API;


use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{

    public function index()
    {
        $posts = Post::all();
        if ($posts) {
            return response()->json(['status' => 'success', 'data' => $posts], 200);
        } else {
            return response()->json(['status' => 'error', 'data' => null, 'message' => 'Service Unavailable'], 503);
        }
    }

    public function store(Request $request)
    {
        $input = $request->all();
        if ($input['post_type_id'] == '1') {
            return $this->storeText($input);
        }
    }

    public function storeText($data)
    {
        $createTextPost = Post::create($data);
        if ($createTextPost) {
            return response()->json(['status' => 'success', 'data' => null], 201);
        } else {
            return response()->json(['status' => 'error', 'data' => "Service temporarily unavailable"], 503);
        }
    }
}
