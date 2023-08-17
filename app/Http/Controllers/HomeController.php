<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home', [
            'title' => 'Latest Posts',
            'active' => 'home',
            "posts" => Post::latest()->take(7)->get()
        ]);
    }
}
