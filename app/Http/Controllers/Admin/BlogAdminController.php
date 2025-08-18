<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogAdminController extends Controller
{
    public function index()
    {
        $blogs = Blog::select('id','title','author','image','created_at')
                     ->orderByDesc('id')->paginate(20);
        return view('admin.blogs.index', compact('blogs'));
    }

    public function create() { return view('admin.blogs.create'); }

    public function store(Request $req)
    {
        $data = $req->validate([
            'title' => 'required|string',
            'author'=> 'required|string',
            'short_description' => 'required|string|max:500',
            'full_content' => 'required|string',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $path = $req->file('image')->store('blogs','public'); // storage/app/public/blogs
        Blog::create($data + ['image' => $path]);

        return redirect()->route('admin.blogs.index');
    }

    public function edit(Blog $blog) { return view('admin.blogs.edit', compact('blog')); }

    public function update(Request $req, Blog $blog)
    {
        $data = $req->validate([
            'title' => 'required|string',
            'author'=> 'required|string',
            'short_description' => 'required|string|max:500',
            'full_content' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($req->hasFile('image')) {
            if ($blog->image) Storage::disk('public')->delete($blog->image);
            $data['image'] = $req->file('image')->store('blogs','public');
        }

        $blog->update($data);
        return redirect()->route('admin.blogs.index');
    }

    public function destroy(Blog $blog)
    {
        if ($blog->image) Storage::disk('public')->delete($blog->image);
        $blog->delete();
        return redirect()->route('admin.blogs.index');
    }
}
