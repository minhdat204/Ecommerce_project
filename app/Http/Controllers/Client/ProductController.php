<?php

namespace App\Http\Controllers\Client;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ProductsDiscount = Product::whereNotNull('gia_khuyen_mai')
            ->with('category')
            ->get();
        $Products = Product::whereNull('gia_khuyen_mai')->paginate(2);
        $ProductsCount = Product::whereNull('gia_khuyen_mai')->count();
        return view('users.pages.shop', compact('Products', 'ProductsDiscount', 'ProductsCount'));
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
        //Dat : lấy chi tiết sản phẩm dựa vào slug
        $Product = Product::where('slug', $slug)->first();

        //Dat: lấy 4 sản phẩm liên quan (Điểm liên quan =  lượt xem 60% + ngẫu nhiên 40%) và xử lý việc không đủ sản phẩm liên quan
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

        return view('users.pages.shop-details', compact('Product', 'relatedProducts'));
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
