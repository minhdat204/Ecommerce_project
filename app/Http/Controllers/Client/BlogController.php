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
        $keyword = $request->input('keyword'); // Lấy từ khóa tìm kiếm từ request

        $posts = Post::query()
            ->when($keyword, function ($query, $keyword) {
                return $query->where('tieude', 'like', "%$keyword%")
                             ->orWhere('noidung', 'like', "%$keyword%");
            })
            ->paginate(6);  

        if ($request->ajax()) {
            return response()->json([
                'posts' => view('users.partials.blog.blog-item', compact('posts'))->render(),
                'pagination' => $posts->appends(['keyword' => $keyword])->links('pagination::bootstrap-4')->render(),
            ]);
        }

        // Trả về view cho request bình thường
        return view('users.pages.blog', compact('posts'));
    }

    /**
     * Display the specified resource.
     */
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
