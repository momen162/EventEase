<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::latest()->get();
        return view('blog.index', compact('blogs'));
    }

    public function show($id)
    {
        $blog = Blog::findOrFail($id);
        return view('blog.show', compact('blog'));
    }
}

