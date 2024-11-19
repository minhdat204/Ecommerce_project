<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryManagerController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with('parentCategory')->get();
        return view('admin.pages.Category.index', compact('categories'));
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
        $request->validate([
            'tendanhmuc' => 'request|string|max:255|unique:danh_muc,tendanhmuc',
        ]);

        //tạo slug
        $slug = Str::slug($request->CategoryName, '-');
        if ($request->hasFile('CategoryImage')) {
            // Lưu ảnh vào thư mục 'public/products'
            $imagePath = $request->file('CategoryImage')->store('categories', 'public');
            Category::create([
                'id_danhmuc_cha' => $request->CategoryParent,
                'tendanhmuc' => $request->CategoryName,
                'slug' => $slug,  // Lưu slug

                'mota' => $request->CategoryContent,
                'thumbnail' => $imagePath,
                'trangthai' => $request->trangthai, // hoặc trạng thái mặc định khác
            ]);
        }
        return redirect()->route('admin.category.index')->with('success', 'Thêm danh mục thành công!');
    }

    /**
     * Display the specified resource.
     */
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
        //
    }
}
