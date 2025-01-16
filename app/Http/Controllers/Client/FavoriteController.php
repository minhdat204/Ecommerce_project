<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\FavoriteProduct;
use App\Models\Product;

class FavoriteController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.guest');
    }

    public function index()
    {
        $favorites = FavoriteProduct::where('id_nguoidung', Auth::id())
            ->with('product')
            ->paginate(3);
        return view('users.pages.favorites', compact('favorites'));
    }

    public function toggle(Product $product)
    {
        $favorite = FavoriteProduct::where('id_nguoidung', Auth::id())
            ->where('id_sanpham', $product->id_sanpham)
            ->first();

        if ($favorite) {
            $favorite->delete();
            $message = 'Đã xóa khỏi danh sách yêu thích';
            $isAdded = false;
        } else {
            FavoriteProduct::create([
                'id_nguoidung' => Auth::id(),
                'id_sanpham' => $product->id_sanpham
            ]);
            $message = 'Đã thêm vào danh sách yêu thích';
            $isAdded = true;
        }

        // số lượng sản phẩm yêu thích
        $favoriteCount = FavoriteProduct::where('id_nguoidung', Auth::id())->count();
        return response()->json([
            'success' => true,
            'message' => $message,
            'isAdded' => $isAdded,
            'redirect_url' => route('favorites.index'),
            'favoriteCount' => $favoriteCount
        ]);
    }

    public function remove(Request $request, $id)
    {
        $favorite = FavoriteProduct::where('id_yeuthich', $id)
            ->where('id_nguoidung', Auth::id())
            ->firstOrFail();

        $favorite->delete();

        // số lượng sản phẩm yêu thích
        $favoriteCount = FavoriteProduct::where('id_nguoidung', Auth::id())->count();

       // Lấy trang hiện tại từ request
       $page = $request->currentPage ?? 1;

       // Lấy danh sách favorites sau khi xóa
       $favorites = FavoriteProduct::with('product') // Quan hệ với sản phẩm
           ->where('id_nguoidung', Auth::id())
           ->paginate(3, ['*'], 'page', $page); // Phân trang ở trang hiện tại

        // Render view partial
        $favoriteView = view('users.partials.favorites.table-favorites', compact('favorites'))->render();

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa sản phẩm khỏi danh sách yêu thích',
            'favoriteCount' => $favoriteCount,
            'favoriteView' => $favoriteView
        ]);
    }

    public function clear()
    {
        $favorites = FavoriteProduct::where('id_nguoidung', Auth::id());

        if ($favorites->count() == 0) {
            return response()->json([
                'success' => false,
                'message' => 'Danh sách yêu thích đã trống'
            ]);
        }

        $favorites->delete();

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa toàn bộ danh sách yêu thích'
        ]);
    }
    public function checkFavorite(Product $product)
    {
        $isFavorited = FavoriteProduct::where('id_nguoidung', Auth::id())
            ->where('id_sanpham', $product->id_sanpham)
            ->exists();

        return response()->json([
            'success' => true,
            'isFavorited' => $isFavorited
        ]);
    }
}
