<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
        {
            // Lấy từ khóa tìm kiếm từ request
            $keyword = $request->input('keyword'); 

            // Truy vấn và phân trang, áp dụng tìm kiếm nếu có keyword
            $posts = Post::query()
                ->when($keyword, function ($query) use ($keyword) {
                    return $query->where('tieude', 'like', "%$keyword%")
                                ->orWhere('noidung', 'like', "%$keyword%");
                })
                ->paginate(3);  // Phân trang 3 bài viết mỗi trang

            // Trả về view với danh sách bài viết
            return view('users.pages.blog', compact('posts'));
        }


    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        // Tìm bài viết theo slug và trả về trang chi tiết bài viết
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
