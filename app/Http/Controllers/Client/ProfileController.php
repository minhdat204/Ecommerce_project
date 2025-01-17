<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Models\FavoriteProduct;
use App\Models\Comment;
use App\Models\Order;
use App\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $user = Auth::id();
        // Đây có thể được thay thế bằng Auth::user() :
        // Lấy các sản phẩm yêu thích của người dùng (ID = 4)
        $favorites = FavoriteProduct::where('id_nguoidung', $user)
            ->join('san_pham', 'san_pham.id_sanpham', '=', 'san_pham_yeu_thich.id_sanpham')
            ->select('san_pham.id_sanpham', 'san_pham.tensanpham', 'san_pham.gia')
            ->orderBy('san_pham_yeu_thich.created_at', 'desc')
            ->paginate(12);
        $scores = Comment::with('product')
            ->where('id_nguoidung', $user)
            ->select('noidung', 'id_sanpham', 'danhgia','created_at')
            ->orderBy('created_at', 'desc')
            ->simplePaginate(12);
        // Lấy danh sách đơn hàng
        $orders = Order::with(['orderDetails.product'])
            ->where('id_nguoidung', $user)
            ->paginate(10);
        return view('users.pages.profile', compact('user', 'favorites', 'scores', 'orders'));
    }
    public function show($userId)
    {
        return view('users.pages.profile', compact('user', 'favorites', 'scores'));
    }
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('profile.edit', compact('user', 'favorites', 'scores'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'hoten' => 'required|string|max:50', 
            'gioitinh' => 'required|in:male,female',
            'diachi' => 'nullable|string|max:50',
            'sodienthoai' => 'nullable|digits:10|numeric', 
        ], [
        ]);
        $user = Auth::user();
        $user->update($request->only(['hoten', 'gioitinh', 'diachi', 'sodienthoai']));
    
        return back()->with('success', 'Information updated successfully!');
    }
    public function destroy(string $id)
{
    $favorite = FavoriteProduct::where('id_nguoidung', Auth::id())
        ->where('id_sanpham', $id)
        ->first();
    if ($favorite) {
        $favorite->delete();
        return redirect()->route('profile.index')->with('success', 'Favorited Product has been removed');
    }
    return redirect()->route('profile.index')->with('error', 'Product not found in favorites');
}
