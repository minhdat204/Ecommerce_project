<?php

namespace App\Http\Controllers\Client;

use App\Models\Post;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Danh sách bài viết với phân trang
        $blogs = Post::paginate(10);
    
        // Lấy 5 bài viết gần đây nhất (không phân trang)
        $recentBlogs = Post::orderBy('created_at', 'desc')->take(5)->get();
    
        // Truyền cả hai dữ liệu sang View
        return view('users.pages.blog', compact('blogs', 'recentBlogs'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $blog = Post::findOrFail($id);
        return view('users.partials.blog.blog-item', compact('blog'));    
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($slug)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
