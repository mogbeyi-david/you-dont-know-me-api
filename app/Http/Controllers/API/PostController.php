<?php

namespace App\Http\Controllers\API;


use App\Post;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Classes\Response as apiResponse;

class PostController extends Controller
{

    public function index()
    {
        try {
            $posts = Post::all();
            return apiResponse::success(200, $posts);
        } catch (QueryException $exception) {
            $message = "Posts could not be fetched at this time";
            return apiResponse::error("503", null, $message);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $posts = Post::where('id', $id)->update([
                'post_type_id' => $request['post_type_id'],
                'post' => $request['post'],
                'caption' => $request['caption']
            ]);
            return apiResponse::success(200, $posts);
        } catch (QueryException $exception) {
            $message = "Posts could not be fetched at this time";
            return apiResponse::error(503, null, $message);
        }
    }

    public function store(Request $request)
    {
        $input = $request->all();
        if ($input['post_type_id'] == '1') {
            return $this->storeText($input);
        }

        if ($input['post_type_id'] == '2') {
            return $this->storeImage($request);
        }

        if ($input['post_type_id'] == '4') {
            return $this->storeVideo($request);
        }
    }

    public function delete($id)
    {
        try {
            $deletePost = Post::destroy($id);
        } catch (QueryException $exception) {
            return response()->json(['status' => 'error', 'data' => "Service temporarily unavailable"], 503);
        }

        if (!$deletePost) {
            return response()->json(['status' => 'error', 'data' => "Service temporarily unavailable"], 404);
        }
        return response()->json(['status' => 'success', 'data' => null], 200);
    }

    protected function storeText($data)
    {
        $createTextPost = Post::create($data);
        if (!$createTextPost) {
            return response()->json(['status' => 'error', 'data' => "Service temporarily unavailable"], 503);
        }
        return response()->json(['status' => 'success', 'data' => null], 201);
    }

    protected function storeImage(Request $request)
    {
        $this->validate($request, ['post' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',]);
        if ($request->hasFile('post')) {
            $image = $request->file('post');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $name);
            Post::create([
                'post_type_id' => $request['post_type_id'],
                'post' => $name,
                'caption' => $request['caption']
            ]);
            return response(['status' => 'success', 'data' => null], 201);
        } else {
            return response(['status' => 'error', 'data' => 'File could not be uploaded at this time'], 503);
        }
    }

    protected function storeVideo(Request $request)
    {
        $rules = ['post' => 'mimes:mpeg,ogg,mp4,webm,3gp,mov,flv,avi,wmv,ts|max:100040|required'];
        $validator = Validator($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'data' => 'please check the video format'], 400);
        } else {
            $video = $request->file('post');
            $name = time() . '.' . $video->getClientOriginalExtension();
            $destinationPath = public_path('videos');
            $video->move($destinationPath, $name);
            $postVideo = Post::create([
                'post_type_id' => $request['post_type_id'],
                'post' => $name,
                'caption' => $request['caption']
            ]);
            if (!$postVideo) {
                return response()->json(['status' => 'error', 'data' => 'Unable to upload video at this time'], 503);
            }
            return response()->json(['status' => 'success', 'data' => null], 201);
        }
    }

}
