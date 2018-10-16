<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Post;

class HomeController extends Controller
{
    public function index()
    {
        return Post::with('comments')->get();
    }
}
