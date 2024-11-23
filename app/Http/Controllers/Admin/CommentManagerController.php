<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Comment;
class CommentManagerController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Comment :: with ('product') 
        -> select ('id_binhluan','noidung', 'danhgia', 'id_sanpham')
        -> paginate (10);
        return view('admin.pages.comment.index', compact('comments'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
    }
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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
  
        $comment = Comment::find($id);

        if ($comment) {
            $comment->delete();
            return redirect()->route('admin.comment.index')->with('success', 'Bình luận đã được xóa.');
        }
    
        return redirect()->route('admin.comment.index')->with('error', 'Không tìm thấy bình luận.');
    }
    
}
