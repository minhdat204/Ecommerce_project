<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ProductManagerController
{
    // Hiển thị danh sách sản phẩm
    public function index(Request $request)
{
    $search = $request->input('search');
    
    $products = Product::with(['category', 'images'])  // Chắc chắn đã lấy thông tin hình ảnh
        ->when($search, function ($query, $search) {
            $query->where('tensanpham', 'like', '%' . $search . '%');
        })
        ->paginate(10);

    // Truyền thông tin hình ảnh vào view
    foreach ($products as $product) {
        $product->images = ProductImage::where('id_sanpham', $product->id_sanpham)->get();
    }

    return view('admin.pages.product.index', compact('products'));
}

    // Hiển thị form thêm mới sản phẩm
    public function create()
{
    $categories = Category::all();  // Lấy tất cả danh mục
    return view('admin.pages.product.create', compact('categories'));
}

public function store(Request $request)
{
    // Validate dữ liệu
    $request->validate([
        'tensanpham' => 'required|string',
        'slug' => 'required|string',
        'mota' => 'required|string',
        'thongtin_kythuat' => 'required|string',
        'id_danhmuc' => 'required|string', // Dữ liệu truyền vào là tên danh mục
        'gia' => 'required|numeric',
        'gia_khuyen_mai' => 'nullable|numeric',
        'donvitinh' => 'required|string',
        'xuatxu' => 'required|string',
        'soluong' => 'required|numeric',
        'trangthai' => 'required|string',
        'luotxem' => 'nullable|numeric',
        'images' => 'nullable|array',
        'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validate ảnh
    ]);

    // Lấy id_danhmuc từ tendanhmuc (tên danh mục)
    $category = Category::where('tendanhmuc', $request->id_danhmuc)->first(); // Tìm danh mục theo tên
    if (!$category) {
        // Nếu không tìm thấy danh mục, trả về lỗi
        return redirect()->back()->withErrors(['id_danhmuc' => 'Danh mục không tồn tại.']);
    }

    // Lưu sản phẩm
    $product = new Product();
    $product->tensanpham = $request->tensanpham;
    $product->slug = $request->slug;
    $product->mota = $request->mota;
    $product->thongtin_kythuat = $request->thongtin_kythuat;
    $product->id_danhmuc = $category->id_danhmuc; // Gán id_danhmuc lấy từ bảng danh_muc
    $product->gia = $request->gia;
    $product->gia_khuyen_mai = $request->gia_khuyen_mai;
    $product->donvitinh = $request->donvitinh;
    $product->xuatxu = $request->xuatxu;
    $product->soluong = $request->soluong;
    $product->trangthai = $request->trangthai;
    $product->luotxem = $request->luotxem;
    $product->save();

    // Xử lý hình ảnh
    // Lưu hình ảnh
    if ($request->hasFile('images')) {
        $images = $request->file('images');
        foreach ($images as $image) {
            // Lưu ảnh vào thư mục storage/app/public/img/products
            $imagePath = $image->store('img/products', 'public');
    
            // Lưu đường dẫn hình ảnh vào bảng hinh_anh_san_pham
            $productImage = new ProductImage();
            $productImage->id_sanpham = $product->id_sanpham; // Giả sử bảng có khóa ngoại id_sanpham
            $productImage->duongdan = $imagePath;
            $productImage->alt = $request->tensanpham; // Hoặc tùy chọn khác
    
            // Bỏ qua việc lưu `created_at` và `updated_at`
            $productImage->save();
        }
    }
    

    return redirect()->route('admin.product.index')->with('success', 'Sản phẩm đã được thêm thành công!');
}







    // Hiển thị chi tiết sản phẩm
    public function show(string $id)
    {
        $product = Product::with('images')->findOrFail($id);
        return view('admin.pages.product.show', compact('product'));
    }

    // Hiển thị form chỉnh sửa sản phẩm
    public function edit(string $id)
    {
        $product = Product::with('images')->findOrFail($id);
        $categories = Category::all();
        return view('admin.pages.product.edit', compact('product', 'categories'));
    }

    // Cập nhật thông tin sản phẩm
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
            'hinh_anh.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $product->update($request->all());

        // Xóa hình ảnh cũ nếu có yêu cầu
        if ($request->has('delete_images')) {
            foreach ($request->input('delete_images') as $imageId) {
                $image = ProductImage::find($imageId);
                if ($image && Storage::disk('public')->exists($image->duongdan)) {
                    Storage::disk('public')->delete($image->duongdan);
                }
                $image?->delete();
            }
        }

        // Thêm hình ảnh mới
        if ($request->hasFile('hinh_anh')) {
            foreach ($request->file('hinh_anh') as $image) {
                $filePath = $image->store('products', 'public');
                ProductImage::create([
                    'id_sanpham' => $product->id_sanpham,
                    'duongdan' => $filePath,
                    'alt' => $request->input('alt', null),
                ]);
            }
        }

        return redirect()->route('admin.product.index')->with('success', 'Sản phẩm được cập nhật thành công!');
    }

    // Xóa sản phẩm
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        // Xóa hình ảnh liên kết
        foreach ($product->images as $image) {
            if (Storage::disk('public')->exists($image->duongdan)) {
                Storage::disk('public')->delete($image->duongdan);
            }
            $image->delete();
        }

        $product->delete();

        return redirect()->route('admin.product.index')->with('success', 'Sản phẩm được xóa thành công!');
    }
}
