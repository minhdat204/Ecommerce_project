<?php

namespace App\Http\Controllers\Client;

use App\Models\Category;
use App\Models\Product;
use App\Models\Comment;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController
{
    /**
     * QUY TẮT
     * 1. phân trang 9 sản phẩm 1 trang
     * 2. comment rõ ràng phần mình làm
     * 3. không dược sửa logic của các hàm đã có nếu chưa trao đổi với nhau
     */

     protected $productService;
     // Inject ProductService vào controller để sử dụng các hàm trong đó (vd như lấy sản phẩm mới, sản phẩm bán chạy, )
     public function __construct(ProductService $productService)
     {
         $this->productService = $productService;
     }

    // lấy ds danh mục theo id hoặc slug
    private function getCategoryByIdOrSlug($category)
    {
        if (is_numeric($category)) {
            return Category::find($category);
        }
        elseif (is_string($category)) {
            return Category::where('slug', $category)->first();
        }
        elseif (is_null($category)) {
            throw new \InvalidArgumentException('Category cannot be null.');
        }
        else {
            throw new \InvalidArgumentException('Invalid category type. Expected integer ID or string slug.');
        }
    }
    /*
    lấy ds danh mục con:
    nhấn vào child thì lấy child, nhấn vào parent thì lấy parent và child
    */
    private function getChildCategories($categoryIdOrSlug)
    {
        $category = $this->getCategoryByIdOrSlug($categoryIdOrSlug);

        // Kiểm tra danh mục tồn tại hay không
        if (!$category) {
            throw new \InvalidArgumentException('Category not found for the provided ID or slug.');
        }

        // Kiểm tra danh mục là cha hay con
        $isParentCategory = is_null($category->id_danhmuc_cha);

        if(!$isParentCategory) {
            // Nếu là danh mục con, trả về danh sách chỉ chứa ID của nó
            return [$category->id_danhmuc];
        }
        // Nếu là danh mục cha, lấy tất cả danh mục con và chính nó
        $categoryIds = Category::where('id_danhmuc_cha', $category->id_danhmuc)
            ->pluck('id_danhmuc')
            ->push($category->id_danhmuc)
            ->toArray();

        return $categoryIds;
    }
    //lấy sản phẩm theo danh mục: truyền (ds sản phẩm , id hoặc slug)
    private function getProductCategory($products, $categoryIdOrSlug)
    {
        $categoryIds = $this->getChildCategories($categoryIdOrSlug);
        $query = $products->whereIn('id_danhmuc', $categoryIds);
        return $query;
    }

    //logic nghiệp vụ
    public function index()
    {
        $productsDiscount = Product::whereNotNull('gia_khuyen_mai')
            ->with('category')
            ->orderByRaw('((gia - COALESCE(gia_khuyen_mai, gia)) / gia) DESC')
            ->limit(9)
            ->get();
        // $products = Product::whereNull('gia_khuyen_mai')->with('category')->paginate(6);
        $products = Product::with(['images' => function($query) {
            $query->select('id_sanpham', 'duongdan', 'alt')->limit(1);
        }])->orderBy('id_sanpham', 'desc')->paginate(9);
        $productsCount = Product::count();
        $categories = Category::all();
        $new_products = $this->productService->getNewProducts(9);
        return view('users.pages.shop', compact('products', 'productsDiscount', 'productsCount', 'categories', 'new_products'));
    }

    public function showCategory(string $slug)
    {
        //lấy danh mục theo slug
        $category = Category::where('slug', $slug)->first();
        $products = Product::query();
        //lấy sản phẩm theo danh mục
        //kiểm tra danh mục đó có thuộc tính danh mục cha không, nếu có cột id_danhmuc_cha thì laf danh mục con, neếu null thì làf cha
        $isParentCategory = is_null($category->id_danhmuc_cha);

        // //nếu ko phải thì chỉ hiển thị ds sp trog 1 mục, có thì hiển thị all danh mục con
        // if(!$isParentCategory)
        //     $query = $product->where('id_danhmuc', $category->id_danhmuc);
        // else {
        //     //lấy danh mục cha và tất cả danh mục con
        //     $categoryIds = Category::where('id_danhmuc_cha', $category->id_danhmuc)
        //         ->pluck('id_danhmuc')
        //         ->push($category->id_danhmuc)
        //         ->toArray();
        //     //lấy tất cả sản phẩm của danh mục cha và danh mục con
        //     $query = Product::whereIn('id_danhmuc', $categoryIds);
        // }
        $query = $this->getProductCategory($products, $slug);
        //lấy số lượng sản phẩm
        $productsCount = $query->count();
        //lấy sản phẩm theo trang
        $products = $query->paginate(9);
        //lấy tất cả danh mục
        $categories = Category::whereNull('id_danhmuc_cha')->with('childCategories')->get();
         // ds sản phẩm mới
        $new_products = $this->productService->getNewProducts(9);
        return view('users.pages.shop', compact('products', 'categories', 'category', 'productsCount', 'new_products'));
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $id_category = $request->input('id_category');
        $minPrice = $request->input('minPrice') ?? 0;
        $maxPrice = $request->input('maxPrice') ??  Product::max('gia');

        // Start query
        $products = Product::with(['images' => function($query) {
            $query->select('id_sanpham', 'duongdan', 'alt')->limit(1);
        }]);

        // Filter by category
        if ($id_category) {
            // $products->where('id_danhmuc', $id_category);
            // $products = $this->getProductCategory($products, $id_category);
            $categoryIds = $this->getChildCategories($id_category);
            $products->whereIn('id_danhmuc', $categoryIds);
        }

        // Filter by keyword (in name or description)
        if ($keyword) {
            $products->where(function ($query) use ($keyword) {
                $query->where('tensanpham', 'like', "%$keyword%")
                      ->orWhere('mota', 'like', "%$keyword%");
            });
        }

        // Filter by price range
        if ($minPrice && $maxPrice) {
            $products->where(function($query) use ($minPrice, $maxPrice) {
                $query->whereBetween('gia', [$minPrice, $maxPrice])
                      ->orWhereBetween('gia_khuyen_mai', [$minPrice, $maxPrice]);
            });
        }

        // Count products before pagination
        $productsCount = $products->count();

        // Paginate products
        $products = $products->orderBy('id_sanpham', 'desc')->paginate(9);

        // Handle AJAX response
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'html' => view('users.partials.shop.products-content',
                    compact('products', 'productsCount'))->render(),
                'count' => $productsCount
            ], 200, ['Content-Type' => 'application/json']);
        }

        // Load categories for the view
        $categories = Category::all();
        // ds sản phẩm mới
        $new_products = $this->productService->getNewProducts(9);
        return view('users.pages.shop', compact('products', 'productsCount', 'categories', 'new_products'));
    }

    /**
     * show chi tiết sản phẩm theo slug
     */
    public function show(string $slug)
    {
        //Dat : lấy chi tiết sản phẩm dựa vào slug
        $Product = Product::with('images')->where('slug', $slug)->first();

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
}
