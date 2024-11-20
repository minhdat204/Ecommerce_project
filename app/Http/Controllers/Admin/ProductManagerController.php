<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductManagerController
{
    /**
     * Display a listing of the products.
     */
    public function index()
    {
        $products = Product::with('category')->paginate(10); // 10 sản phẩm mỗi trang
        return view('admin.pages.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
{
    $categories = Category::all(); // Lấy tất cả danh mục từ bảng danh_muc
    return view('admin.pages.product.create', compact('categories'));
}



    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'tensanpham' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:san_pham',
        'mota' => 'required|string',
        'gia' => 'required|numeric',
        'gia_khuyen_mai' => 'nullable|numeric',
        'donvitinh' => 'required|string',
        'thongtin_kythuat'=> 'required|string',
        'xuatxu' => 'required|string',
        'soluong' => 'required|integer',
        'trangthai' => 'required|boolean',
        'luotxem' => 'nullable|integer',
        'id_danhmuc' => 'required|exists:danh_muc,id_danhmuc', // Kiểm tra id_danhmuc có tồn tại
    ]);

    Product::create($request->all());
    return redirect()->route('admin.product.index')->with('success', 'Sản phẩm được thêm thành công!');
}


    /**
     * Show the specified product.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        return view('admin.pages.product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.pages.product.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);
        $request->validate([
            'tensanpham' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:san_pham,slug,' . $product->id_sanpham,
            'mota' => 'required|string',
            'gia' => 'required|numeric',
            'gia_khuyen_mai' => 'nullable|numeric',
            'donvitinh' => 'required|string',
            'xuatxu' => 'required|string',
            'soluong' => 'required|integer',
            'trangthai' => 'required|boolean',
            'luotxem' => 'nullable|integer',
        ]);

        $product->update($request->all());
        return redirect()->route('admin.product.index');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('admin.product.index');
    }
}
