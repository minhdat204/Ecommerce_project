<?php

namespace App\Http\Controllers\Client;

use App\Models\Category;
use App\Models\Product;
use App\Models\Comment;

use Illuminate\Http\Request;

class ProductController
{
    /**
     * QUY TẮT
     * 1. phân trang 9 sản phẩm 1 trang
     * 2. comment rõ ràng phần mình làm
     * 3. không dược sửa logic của các hàm đã có nếu chưa trao đổi với nhau
     */
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productsDiscount = Product::whereNotNull('gia_khuyen_mai')
            ->with('category')
            ->orderByRaw('((gia - COALESCE(gia_khuyen_mai, gia)) / gia) DESC')
            ->limit(9)
            ->get();
        // $products = Product::whereNull('gia_khuyen_mai')->with('category')->paginate(6);
        $products = Product::paginate(9);
        $productsCount = Product::count();
        $categories = Category::all();
        return view('users.pages.shop', compact('products', 'productsDiscount', 'productsCount', 'categories'));
    }

    public function showCategory(string $slug)
    {
        $category = Category::where('slug', $slug)->first();
        //kiểm tra id có phải danh mục cha không
        $isParentCategory = is_null($category->id_danhmuc_cha);

        //nếu ko phải thì chỉ hiển thị ds sp trog 1 mục, có thì hiển thị all danh mục con
        if(!$isParentCategory)
            $query = Product::where('id_danhmuc', $category->id_danhmuc);
        else {
            //lấy danh mục cha và tất cả danh mục con
            $categoryIds = Category::where('id_danhmuc_cha', $category->id_danhmuc)
                ->pluck('id_danhmuc')
                ->push($category->id_danhmuc)
                ->toArray();
            //lấy tất cả sản phẩm của danh mục cha và danh mục con
            $query = Product::whereIn('id_danhmuc', $categoryIds);
        }
        //lấy số lượng sản phẩm
        $productsCount = $query->count();
        //lấy sản phẩm theo trang
        $products = $query->paginate(9);
        //lấy tất cả danh mục
        $categories = Category::whereNull('id_danhmuc_cha')->with('childCategories')->get();
        return view('users.pages.shop', compact('products', 'categories', 'category', 'productsCount'));
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $id_category = $request->input('id_category');

        if ($id_category) {
            //tìm kiếm sản phẩm theo tên hoặc mô tả và danh mục
            $products = Product::where('id_danhmuc', $id_category)
                ->where('tensanpham', 'like', "%$keyword%")
                ->orWhere('mota', 'like', "%$keyword%")
                ->paginate(9);
        } else {
            //tìm kiếm sản phẩm theo tên hoặc mô tả
            $products = Product::where('tensanpham', 'like', "%$keyword%")
                ->orWhere('mota', 'like', "%$keyword%")
                ->paginate(9);
        }

        $productsCount = $products->count();
        $categories = Category::all();
        return view('users.pages.shop', compact('products', 'productsCount', 'categories'));
    }

    /**
     * show chi tiết sản phẩm theo slug
     */
    public function show(string $slug)
    {
        //Dat : lấy chi tiết sản phẩm dựa vào slug
        $Product = Product::where('slug', $slug)->first();

        //Dat: lấy 4 sản phẩm liên quan (Điểm liên quan = lượt xem 60% + ngẫu nhiên 40%)
        $initialRelated = Product::where('id_danhmuc', $Product->id_danhmuc)
            ->where('id_sanpham', '!=', $Product->id_sanpham)
            ->orderByRaw('(luotxem * 0.6) + (RAND() * 0.4) DESC')
            ->take(4)
            ->get();

        if ($initialRelated->count() < 4) {
            $remainingCount = 4 - $initialRelated->count();
            $randomProducts = Product::where('id_sanpham', '!=', $Product->id_sanpham)
                ->whereNotIn('id_sanpham', $initialRelated->pluck('id_sanpham'))
                ->inRandomOrder()
                ->take($remainingCount)
                ->get();

            $relatedProducts = $initialRelated->concat($randomProducts);
        } else {
            $relatedProducts = $initialRelated;
        }

        //Khoa: lấy dữ liệu comments
        $reviews = Comment::where('id_sanpham', $Product->id_sanpham)
            ->whereNull('parent_id')
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        $totalReviews = $reviews->count();
        $averageRating = $reviews->avg('danhgia') ?? 0;

        $ratingStats = [
            5 => $reviews->where('danhgia', 5)->count(),
            4 => $reviews->where('danhgia', 4)->count(),
            3 => $reviews->where('danhgia', 3)->count(),
            2 => $reviews->where('danhgia', 2)->count(),
            1 => $reviews->where('danhgia', 1)->count(),
        ];

        $userReview = null;

        return view('users.pages.shop-details', compact(
            'Product',
            'relatedProducts',
            'reviews',
            'totalReviews',
            'averageRating',
            'ratingStats',
            'userReview'
        ));
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
