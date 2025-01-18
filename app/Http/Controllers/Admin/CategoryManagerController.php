<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage; // Add this import
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CategoryManagerController
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $categories = Category::with('parentCategory')
            //when(column,operator,value)
            ->when($search, function ($query) use ($search) {
                return $query->where('tendanhmuc', 'LIKE', '%' . trim($search) . '%')
                    ->orWhere('mota', 'LIKE', '%' . trim($search) . '%');
            })
            ->orderBy('created_at', 'desc') // Sắp xếp thời gian từ mới đến cũ

            ->paginate(10); // Hiển thị 10 mục mỗi trang
        // Lấy danh mục cha
        $parentCategories = Category::where('trangthai', 'active')->get();

        return view('admin.pages.Category.index', compact('categories', 'parentCategories', 'search'));
    }
    public function create()
    {
        $parentCategories = Category::where('trangthai', 'active')
            ->get();

        return view('admin.pages.Category.index', compact('category', 'parentCategories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'CategoryName' => 'required|string|max:100|unique:danh_muc,tendanhmuc',
            'CategoryImage' => 'required|image|max:2048',
            'CategoryContent' => 'required',
            'TrangThai' => 'required|in:active,inactive'
        ], [
            'CategoryName.required' => 'Tên danh mục không được để trống',
            'CategoryName.unique' => 'Tên danh mục đã tồn tại',
            'CategoryName.max' => 'Tên danh mục không được vượt quá 100 ký tự',
            'CategoryImage.required' => 'Hình ảnh không được để trống',
            'CategoryImage.image' => 'File phải là hình ảnh',
            'CategoryImage.max' => 'Kích thước hình ảnh không được vượt quá 2MB',
            'CategoryContent.required' => 'Mô tả không được để trống',
            'TrangThai.required' => 'Trạng thái không được để trống',
            'TrangThai.in' => 'Trạng thái không hợp lệ',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('showModal', true);
        }
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
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $category = Category::findOrFail($id);

        // Lấy tất cả danh mục cha có trạng thái active, ngoại trừ danh mục hiện tại
        $parentCategories = Category::where('trangthai', 'active')
            ->where('id_danhmuc', '!=', $id) // Loại trừ danh mục hiện tại
            ->get();

        return view('admin.pages.Category.index', compact('category', 'parentCategories'));
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'CategoryName' => [
                'required',
                'string',
                'max:100',
                Rule::unique('danh_muc', 'tendanhmuc')->ignore($id, 'id_danhmuc')
            ],
            'CategoryContent' => 'required',
            'Status' => 'required|in:active,inactive',
            'CategoryImage' => 'nullable|image|max:2048'
        ], [
            'CategoryName.required' => 'Tên danh mục không được để trống',
            'CategoryName.unique' => 'Tên danh mục đã tồn tại',
            'CategoryContent.required' => 'Mô tả không được để trống',
            'CategoryImage.image' => 'File phải là hình ảnh'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('showModal', true)
                ->with('editId', $id);
        }
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
