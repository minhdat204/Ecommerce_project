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
    
    // Bắt đầu truy vấn với eager loading category và images
    $products = Product::with(['category', 'images'])
        ->when($search, function ($query, $search) {
            // Áp dụng tìm kiếm nếu có
            $query->where('tensanpham', 'like', '%' . $search . '%');
        })
        // Lọc sản phẩm có trạng thái không phải 'inactive'
        ->where('trangthai', '!=', 'inactive')
        ->paginate(10);

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
    public function show($id_sanpham)
    {
        $product = Product::with('category', 'images')->findOrFail($id_sanpham); // Lấy sản phẩm theo ID
        return view('admin.pages.product.show', compact('product'));
    }


    // Hiển thị form chỉnh sửa sản phẩm
    public function edit(string $id_sanpham)
{
    $product = Product::with('images')->findOrFail($id_sanpham);
    $categories = Category::all();
    return view('admin.pages.product.edit', compact('product', 'categories'));
}


    // Cập nhật thông tin sản phẩm
    public function update(Request $request, string $id_sanpham)
{
    // Lấy thông tin sản phẩm theo ID
    $product = Product::findOrFail($id_sanpham); 

    // Validate dữ liệu
    $request->validate([
        'tensanpham' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:san_pham,slug,' . $product->id_sanpham . ',id_sanpham',
        'mota' => 'required|string',
        'gia' => 'required|numeric',
        'gia_khuyen_mai' => 'nullable|numeric',
        'donvitinh' => 'required|string',
        'xuatxu' => 'required|string',
        'soluong' => 'required|integer',
        'trangthai' => 'required|string|in:active,inactive',
        'images' => 'nullable|array',
        'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Cập nhật các thông tin sản phẩm
    $product->tensanpham = $request->tensanpham;
    $product->slug = $request->slug;
    $product->mota = $request->mota;
    $product->gia = $request->gia;
    $product->gia_khuyen_mai = $request->gia_khuyen_mai;
    $product->donvitinh = $request->donvitinh;
    $product->xuatxu = $request->xuatxu;
    $product->soluong = $request->soluong;
    $product->trangthai = $request->trangthai;
    $product->save();

    // Xử lý hình ảnh nếu có
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $imagePath = $image->store('img/products', 'public');
            $productImage = new ProductImage();
            $productImage->id_sanpham = $product->id_sanpham; // Giữ nguyên id_sanpham tự động
            $productImage->duongdan = $imagePath;
            $productImage->alt = $product->tensanpham; // Hoặc sử dụng tên sản phẩm làm alt
            $productImage->save();
        }
    }

    // Xử lý xóa hình ảnh nếu có yêu cầu
    if ($request->has('delete_images')) {
        foreach ($request->input('delete_images') as $imageId) {
            $image = ProductImage::find($imageId);
            if ($image && Storage::disk('public')->exists($image->duongdan)) {
                Storage::disk('public')->delete($image->duongdan);
            }
            $image?->delete();
        }
    }

    return redirect()->route('admin.product.index')->with('success', 'Sản phẩm đã được cập nhật thành công!');
}


// Ẩn sản phẩm
public function destroy($id_sanpham)
{
    $product = Product::findOrFail($id_sanpham);
    $product->trangthai = 'inactive';
    $product->save();

    return redirect()->route('admin.product.index')->with('success', 'Sản phẩm đã được ẩn');
}
public function hide($id)
{
    $product = Product::findOrFail($id);
    
    // Cập nhật trạng thái sản phẩm thành 'inactive'
    $product->trangthai = 'inactive';
    $product->save();

    return redirect()->route('admin.product.index')->with('success', 'Sản phẩm đã được ẩn');
}

}
