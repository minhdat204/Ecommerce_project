<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage; // Add this import
class CategoryManagerController
{
    public function index()
    {
        $categories = Category::with('parentCategory')->get();
        return view('admin.pages.Category.index', compact('categories'));
    }

    public function create()
    {
        $categories = Category::where('trangthai', 'active')
            ->get();
        return view('admin.category.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tendanhmuc' => 'required|string|max:255|unique:danh_muc,tendanhmuc',
        ]);

        $slug = Str::slug($request->CategoryName, '-');
        if ($request->hasFile('CategoryImage')) {
            $imagePath = $request->file('CategoryImage')->store('categories', 'public');
            $category = Category::create([
                'id_danhmuc_cha' => $request->CategoryParent ?: null,
                'tendanhmuc' => $request->CategoryName,
                'slug' => $slug,
                'mota' => $request->CategoryContent,
                'thumbnail' => $imagePath,
                'trangthai' => $request->TrangThai
            ]);
        }

        return redirect()->route('admin.category.index')->with('success', 'Thêm danh mục thành công!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category.edit', compact('category'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'CategoryName' => 'required|string|max:255',
            'CategoryContent' => 'required',
            'Status' => 'required|in:active,inactive',
            'CategoryImage' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {

            $category = Category::findOrFail($id);

            // Cập nhật thông tin cơ bản
            $category->tendanhmuc = $request->CategoryName;
            $category->slug = Str::slug($request->CategoryName);
            $category->mota = $request->CategoryContent;
            $category->id_danhmuc_cha = $request->CategoryParent ?: null;
            $category->trangthai = $request->Status;

            // Xử lý upload ảnh nếu có
            if ($request->hasFile('CategoryImage')) {
                // Xóa ảnh cũ nếu có
                if ($category->thumbnail && Storage::disk('public')->exists($category->thumbnail)) {
                    Storage::disk('public')->delete($category->thumbnail);
                }

                // Upload ảnh mới
                $imagePath = $request->file('CategoryImage')->store('categories', 'public');
                $category->thumbnail = $imagePath;
            }

            // Lưu thay đổi
            $result = $category->save();


            return redirect()->route('admin.category.index')
                ->with('success', 'Cập nhật danh mục thành công');
        } catch (\Exception $e) {

            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi cập nhật danh mục')
                ->withInput();
        }
    }
    public function destroy(string $id)
    {
        //
    }
}
