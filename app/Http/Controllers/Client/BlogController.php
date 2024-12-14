<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request){

    $keyword = $request->input('keyword'); 

    // Truy vấn bài viết với điều kiện tìm kiếm
    $posts = Post::query()
        ->when($keyword, function ($query, $keyword) {
            return $query->where('tieude', 'like', "%$keyword%")
                         ->orWhere('noidung', 'like', "%$keyword%");
        })
        ->paginate(6);  

    // Kiểm tra yêu cầu AJAX
    if ($request->ajax()) {
        // Trả về JSON cho yêu cầu AJAX
        return response()->json([
            'posts' => view('users.partials.blog.blog-item', ['posts' => $posts])->render(),
            'pagination' => $posts->appends(key: ['keyword' => $keyword])->links('pagination::bootstrap-4')->render(),
        ]);
    }

    // Trả về view cho yêu cầu bình thường
    return view('users.pages.blog', [
        'posts' => $posts, 
        'keyword' => $keyword // Thêm biến keyword để sử dụng trong view nếu cần
    ]);
}
    public function show($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();

        return view('users.pages.blog-detail', compact('post'));
    }

    // Các hàm create, store, edit, update, destroy chưa sử dụng sẽ để trống
    public function create() {}
    public function store(Request $request) {}
    public function edit(Post $post) {}
    public function update(Request $request, Post $post) {}
    public function destroy(Post $post) {}
}
