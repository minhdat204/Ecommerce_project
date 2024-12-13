<?php

namespace App\Http\Controllers\Client;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
    
        $blogs = Blog::query()
            ->when($keyword, function($query, $keyword) {
                return $query->where('title', 'like', "%$keyword%")
                             ->orWhere('content', 'like', "%$keyword%");
            })
            ->paginate(3);  // Phân trang 6 bài mỗi trang
    
        if ($request->ajax()) {
            return response()->json([
                'blogs' => view('users.partials.blog.blog-item', compact('blogs'))->render(),
                'pagination' => view('pagination::bootstrap-4', ['paginator' => $blogs])->render(),
            ]);
        }
    
        return view('users.pages.blog', compact('blogs'));
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
    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();
        return view('blogs.show', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        //
    }
}
