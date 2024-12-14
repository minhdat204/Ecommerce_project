<?php

namespace App\Http\Controllers\Client;

use App\Models\Product;
use App\Models\Comment;
use App\Models\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $product = Product::where('slug', $slug)->firstOrFail();

        $reviews = Comment::where('id_sanpham', $product->id_sanpham)
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

        // First render the comment view with all required variables
        $commentView = view('users.partials.shop-details.comment')
            ->with('product', $product)
            ->with('reviews', $reviews)
            ->with('totalReviews', $totalReviews)
            ->with('averageRating', $averageRating)
            ->with('ratingStats', $ratingStats)
            ->with('userReview', $userReview)
            ->render();

        // Then pass both product and rendered commentView to the main view
        return view('users.pages.shop-details', compact('product', 'commentView'));
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
