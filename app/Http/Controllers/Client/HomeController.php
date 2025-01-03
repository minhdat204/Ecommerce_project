<?php

namespace App\Http\Controllers\Client;

use App\Models\Category;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController
{
    protected $productService;
    // Inject ProductService vào controller
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        // slider : Lấy 3 sản phẩm có đánh giá tốt nhất và giảm giá nhiều nhất
        $slider = $this->productService->getSliderProducts();

        //sản phẩm bán chạy: hiển thị 8 sản phẩm bán chạy nhất
        $best_selling_products = $this->productService->getBestSellingProducts();

        // sản phâm mới: hiển thị 8 sản phẩm mới nhất
        $new_products = $this->productService->getNewProducts();

        //hiển thị 1 số danh mục sản phẩm có trong cơ sở dữ liệu, với công thức là lấy 4 danh mục có nhiều sản phẩm nhất
        $categories = $this->productService->getCategories();

        return view('users.pages.home', compact('slider', 'best_selling_products', 'new_products', 'categories'));
    }
}
