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
            ->paginate(15);

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
        $product = Product::findOrFail($id_sanpham);
        $count = DB::table('san_pham_gio_hang')
            ->where('id_sanpham', $id_sanpham)
            ->sum('id_sanpham');       
        $thoigian = $product->updated_at;
        $product = Product::with('images')->findOrFail($id_sanpham);
        $categories = Category::all();
        return view('admin.pages.product.edit', compact('product', 'categories', 'count', 'thoigian'));
    }


    // Cập nhật thông tin sản phẩm
    public function update(Request $request, string $id_sanpham)
{
    // Lấy thông tin sản phẩm hiện tại
    $product = Product::findOrFail($id_sanpham);

    // Validate dữ liệu
    $request->validate([
        'tensanpham' => 'required|string|max:255|unique:san_pham,tensanpham,' . $id_sanpham . ',id_sanpham',
        'slug' => 'nullable|string', // Slug có thể để trống
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

    // Cập nhật thông tin sản phẩm
    $product->tensanpham = $request->tensanpham;
    $product->slug = Str::slug($request->tensanpham);
    $product->mota = $request->mota;
    $product->gia = $request->gia;
    $product->gia_khuyen_mai = $request->gia_khuyen_mai;
    $product->donvitinh = $request->donvitinh;
    $product->xuatxu = $request->xuatxu;
    $product->soluong = $request->soluong;
    $product->trangthai = $request->trangthai === 'active' ? 1 : 0;
    $product->save();

    // Xử lý hình ảnh mới nếu có
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $imagePath = $image->store('img/products', 'public');
            $productImage = new ProductImage();
            $productImage->id_sanpham = $product->id_sanpham;
            $productImage->duongdan = $imagePath;
            $productImage->alt = $product->tensanpham;
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
}
