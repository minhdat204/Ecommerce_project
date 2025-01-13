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
            ->paginate(10);
        $scores = Comment::with('product')
            ->where('id_nguoidung', $user)
            ->select('noidung', 'id_sanpham', 'danhgia')
            ->paginate(10);
        // Lấy danh sách đơn hàng
        $orders = Order::with(['orderDetails.product'])
            ->where('id_nguoidung', $user)
            ->paginate(2);
        return view('users.pages.profile', compact('user', 'favorites', 'scores', 'orders'));
    }
    public function show($userId)
    {
        return view('users.pages.profile', compact('user', 'favorites', 'scores'));
    }
    public function edit(string $id) {
        $user = User::findOrFail($id);
            return view('profile.edit', compact('user', 'favorites', 'scores'));
    }
    public function update(Request $request, $id) {
        $request->validate([
            'hoten' => 'required|string|max:255',
            'gioitinh' => 'required|in:male,female',
            'diachi' => 'nullable|string|max:255',
            'sodienthoai' => 'nullable|string|max:15',
        ]);
            $user = User::findOrFail($id);
        $user->hoten = $request->input('hoten');
        $user->gioitinh = $request->input('gioitinh');
        $user->diachi = $request->input('diachi');
        $user->sodienthoai = $request->input('sodienthoai');
        $user->save();
            return redirect()->route('profile.index');
    }
    public function destroy(string $id)
    {
        // Logic xóa người dùng hoặc các sản phẩm yêu thích, đánh giá, nếu cần
    }

    /**
     * Show the favorite products page.
     */
   
}