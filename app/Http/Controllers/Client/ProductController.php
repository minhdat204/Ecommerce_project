<?php

namespace App\Http\Controllers\Client;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController
{
    /**
     * Display a listing of the resource.
     */
        public function index(Request $request)
    {
        $categories = Category::getParentCategories(); // Lấy tất cả các danh mục cấp 1

        // Lấy giá trị min và max từ bảng sản phẩm
        $minPrice = Product::min('gia'); // giá trị thấp nhất trong bảng san_pham
        $maxPrice = Product::max('gia'); // giá trị cao nhất trong bảng san_pham

        // Lọc sản phẩm khuyến mãi theo mức giá nếu có
        $queryDiscount = Product::whereNotNull('gia_khuyen_mai');
        
        if ($request->has('min_price') && $request->has('max_price')) {
            $queryDiscount->whereBetween('gia_khuyen_mai', [$request->min_price, $request->max_price]);
        }

        $ProductsDiscount = $queryDiscount->with('category')->get();
        
        // Lọc các sản phẩm không có khuyến mãi
        $query = Product::query();
        
        if ($request->has('min_price') && $request->has('max_price')) {
            $query->whereBetween('gia', [$request->min_price, $request->max_price]);
        }

        // Các sản phẩm không có khuyến mãi
        $Products = $query->whereNull('gia_khuyen_mai')->paginate(2);

        // Số lượng sản phẩm không có khuyến mãi
        $ProductsCount = Product::whereNull('gia_khuyen_mai')->count();

        return view('users.pages.shop', compact('Products', 'ProductsDiscount', 'ProductsCount', 'categories', 'minPrice', 'maxPrice'));
    }


    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        // Lấy chi tiết sản phẩm dựa vào slug
        $Product = Product::where('slug', $slug)->first();
        
        return view('users.pages.shop-details', compact('Product'));
    }
    public function showByCategory($categoryId)
{
    // Lấy sản phẩm theo danh mục
    $products = Product::where('id_danhmuc', $categoryId)->paginate(2);
    $categories = Category::getParentCategories(); // Lấy danh mục cấp 1
    $ProductsDiscount = Product::whereNotNull('gia_khuyen_mai')->with('category')->get(); // Lấy các sản phẩm có khuyến mãi
    
    return view('users.pages.shop', compact('products', 'categories', 'ProductsDiscount'));
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
    public function category(Category $category)
{
    $products = Product::where('id_danhmuc', $category->id_danhmuc)->get();
    return view('users.pages.shop', compact('products', 'category'));
}
}
