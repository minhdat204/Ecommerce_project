<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ProductManagerController
{
    public function index(Request $request)
{
    // Lấy các tham số từ form
    $search = $request->input('search');
    $minPrice = $request->input('min_price');
    $maxPrice = $request->input('max_price');
    $xuatxu = $request->input('xuatxu');
    $idDanhMuc = $request->input('id_danhmuc');
    $status = $request->input('trangthai', 'active');
    // Query sản phẩm
    $products = Product::with(['category', 'images'])
        ->when($search, function ($query) use ($search) {
            return $query->where('tensanpham', 'like', '%' . $search . '%');
        })
        ->when($minPrice, function ($query) use ($minPrice) {
            return $query->where('gia', '>=', $minPrice);
        })
        ->when($maxPrice, function ($query) use ($maxPrice) {
            return $query->where('gia', '<=', $maxPrice);
        })
        ->when($xuatxu, function ($query) use ($xuatxu) {
            return $query->where('xuatxu', $xuatxu);
        })
        ->when($idDanhMuc, function ($query) use ($idDanhMuc) {
            return $query->where('id_danhmuc', $idDanhMuc);
        })
        ->where('trangthai', $status)
        ->paginate(5);

    // Lấy danh sách xuất xứ và danh mục cho dropdown
    $countries = Product::select('xuatxu')->distinct()->pluck('xuatxu');
    $categories = Category::all();

    return view('admin.pages.product.index', compact('products', 'countries', 'categories'));
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
        'tensanpham' => 'required|string|max:255',        
        'slug' => 'required|string',
        'mota' => 'required|string',
        'thongtin_kythuat' => 'required|string',
        'id_danhmuc' => 'required|string', // Dữ liệu truyền vào là tên danh mục
        'gia' => 'required|numeric|min:0',
        'gia_khuyen_mai' => 'nullable|numeric|min:0|lt:gia',
        'donvitinh' => 'required|string',
        'xuatxu' => 'required|string',
        'soluong' => 'required|numeric|min:0',
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
    $tensanpham = $request->tensanpham;
    $slug = Str::slug($tensanpham);

    $slugCount = 1;
    $originalSlug = $slug; 
    while (Product::where('slug', $slug)->exists()) {
        $slug = $originalSlug . '-' . $slugCount;
        $slugCount++; 
    }

    $product = new Product();
    $product->tensanpham = $request->tensanpham;
    $product->slug = $slug;    
    $product->mota = $request->mota;
    $product->thongtin_kythuat = $request->thongtin_kythuat;
    $product->id_danhmuc = $category->id_danhmuc; 
    $product->gia = $request->gia;
    $product->gia_khuyen_mai = $request->gia_khuyen_mai;
    $product->donvitinh = $request->donvitinh;
    $product->xuatxu = $request->xuatxu;
    $product->soluong = $request->soluong;
    $product->trangthai = $request->trangthai === 'active' ? 1 : 0;  
    $product->luotxem = $request->luotxem ?? 0;    
    $product->save();

     // Xử lý hình ảnh
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
    
            // Bỏ qua việc lưu `created_at` và `updated_at` nếu sử dụng Eloquent, vì đã có time stamp tự động
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
        'mota' => 'required|string',
        'gia' => 'required|numeric|min:0',
        'gia_khuyen_mai' => 'nullable|numeric|min:0|lt:gia',
        'donvitinh' => 'required|string',
        'xuatxu' => 'required|string',
        'soluong' => 'required|integer|min:0',
        'trangthai' => 'required|string|in:active,inactive',
        'images' => 'nullable|array',
        'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Cập nhật các thông tin sản phẩm
    $product->tensanpham = $request->tensanpham;
    $product->slug = Str::slug($request->input('tensanpham'));    
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
    try {
        $product = Product::findOrFail($id_sanpham);

        $product->update([
            'trangthai' => 'inactive'
        ]);

        return redirect()->route('admin.product.index')
            ->with('success', 'Sản phẩm đã được ẩn thành công');
    } catch (\Exception $e) {
        return redirect()->route('admin.product.index')
            ->with('error', 'Có lỗi xảy ra khi ẩn sản phẩm: ' . $e->getMessage());
    }
}

}
