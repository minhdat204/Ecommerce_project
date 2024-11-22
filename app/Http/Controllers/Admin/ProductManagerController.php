<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductManagerController
{

    public function index(Request $request)
{
    $search = $request->input('search');

    $products = Product::with('category') 
        ->when($search, function ($query, $search) {
            $query->where('tensanpham', 'like', '%' . $search . '%'); 
        })
        ->paginate(10); 

    return view('admin.pages.product.index', compact('products'));
}


    public function create()
{
    $categories = Category::all();
    return view('admin.pages.product.create', compact('categories'));
}



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
        'id_danhmuc' => 'required|exists:danh_muc,id_danhmuc', 
    ]);

    Product::create($request->all());
    return redirect()->route('admin.product.index')->with('success', 'Sản phẩm được thêm thành công!');
}


    
    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        return view('admin.pages.product.show', compact('product'));
    }

  
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.pages.product.edit', compact('product', 'categories'));
    }

    
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

   
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('admin.product.index');
    }
}
