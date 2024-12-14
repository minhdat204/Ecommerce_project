<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryManagerController
{
<<<<<<< HEAD
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
=======
    public function index(Request $request)
    {
        $search = $request->input('search');

        $categories = Category::with('parentCategory')
            ->when($search, function ($query) use ($search) {
                return $query->where('tendanhmuc', 'LIKE', '%' . trim($search) . '%')
                    ->orWhere('mota', 'LIKE', '%' . trim($search) . '%');
            })
            ->paginate(10); // Hiển thị 6 mục mỗi trang
        // Lấy danh mục cha
        $parentCategories = Category::where('trangthai', 'active')->get();

        return view('admin.pages.Category.index', compact('categories', 'parentCategories', 'search'));
    }
    public function create()
    {
        $parentCategories = Category::where('trangthai', 'active')
            ->get();

        return view('admin.pages.Category.index', compact('category', 'parentCategories'));
>>>>>>> c82ac2319a7b1ec062d997c37eb818d154220a47
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
<<<<<<< HEAD
        //
=======
        $request->validate([
            'CategoryName' => 'required|string|max:100|unique:danh_muc,tendanhmuc',  // Kiểm tra tên danh mục
            'CategoryParent' => 'nullable|exists:danh_muc,id_danhmuc',  // Kiểm tra danh mục cha (nếu có)
            'CategoryContent' => 'nullable|string',  // Mô tả có thể rỗng
            'CategoryImage' => 'nullable|image|max:2048',  // Kiểm tra ảnh nếu có
            'TrangThai' => 'required|in:active,inactive',  // Trạng thái chỉ có thể là 'active' hoặc 'inactive'
        ]);

        $slug = Str::slug($request->CategoryName, '-');
        if ($request->hasFile('CategoryImage')) {
            $imagePath = $request->file('CategoryImage')->store('categories', 'public');
            $category = Category::create([
                'id_danhmuc_cha' => $request->CategoryParent,
                'tendanhmuc' => $request->CategoryName,
                'slug' => $slug,
                'mota' => $request->CategoryContent,
                'thumbnail' => $imagePath,
                'trangthai' => $request->TrangThai
            ]);
        }

        return redirect()->route('admin.category.index')->with('success', 'Thêm danh mục thành công!');
>>>>>>> c82ac2319a7b1ec062d997c37eb818d154220a47
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
<<<<<<< HEAD
        //
=======
        $category = Category::findOrFail($id);

        // Lấy tất cả danh mục cha có trạng thái active, ngoại trừ danh mục hiện tại
        $parentCategories = Category::where('trangthai', 'active')
            ->where('id_danhmuc', '!=', $id) // Loại trừ danh mục hiện tại
            ->get();

        return view('admin.pages.Category.index', compact('category', 'parentCategories'));
>>>>>>> c82ac2319a7b1ec062d997c37eb818d154220a47
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
<<<<<<< HEAD
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
=======
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
            $category->id_danhmuc_cha = $request->CategoryParent;
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
    public function destroy($id)
>>>>>>> c82ac2319a7b1ec062d997c37eb818d154220a47
    {
        try {
            $category = Category::findOrFail($id);

            // Cập nhật trạng thái thành "inactive"
            $category->update([
                'trangthai' => 'inactive'
            ]);
            return redirect()->route('admin.category.index')
                ->with('success', 'Xóa danh mục thành công');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi xóa danh mục: ' . $e->getMessage()
            ]);
        }
    }
}
