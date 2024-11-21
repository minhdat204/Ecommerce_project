<?php
namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Models\FavoriteProduct;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Routing\Controller;
class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Lấy thông tin người dùng theo ID 4 (hoặc ID của người dùng đang đăng nhập)
        $user = User::findOrFail(4); // Đây có thể được thay thế bằng Auth::user() nếu sử dụng tính năng đăng nhập.

        // Lấy các sản phẩm yêu thích của người dùng (ID = 4)
        $favorites = FavoriteProduct::where('id_nguoidung', 4)
            ->join('san_pham', 'san_pham.id_sanpham', '=', 'san_pham_yeu_thich.id_sanpham')
            ->select('san_pham.id_sanpham', 'san_pham.tensanpham', 'san_pham.gia')
            ->paginate(10); // Phân trang cho danh sách sản phẩm yêu thích

        // Lấy đánh giá của người dùng đối với các sản phẩm
        $scores = Comment::where('id_nguoidung', 4)
            ->join('binh_luan', 'binh_luan.id_sanpham', '=', 'san_pham.id_sanpham') // Liên kết với bảng binh_luan
            ->select('binh_luan.id_sanpham', 'binh_luan.noidung', 'binh_luan.danhgia')
            ->paginate(10);

        return view('users.pages.profile', compact('user', 'favorites', 'scores'));
    }

    /**
     * Show the profile of a specific user.
     */
    public function show($userId)
    {
        // Lấy thông tin người dùng theo ID
        $user = User::find($userId);

        // Kiểm tra nếu người dùng không tồn tại
        if (!$user) {
            return redirect()->route('profile.index')->with('error', 'Người dùng không tồn tại');
        }

        // Lấy các sản phẩm yêu thích của người dùng
        $favorites = FavoriteProduct::where('id_nguoidung', $userId)
            ->join('san_pham', 'san_pham.id_sanpham', '=', 'san_pham_yeu_thich.id_sanpham')
            ->select('san_pham.id_sanpham', 'san_pham.tensanpham', 'san_pham.gia', 'san_pham.image')
            ->paginate(10);

        // Lấy các đánh giá của người dùng đối với các sản phẩm
        $scores = Comment::where('id_nguoidung', $userId)
            ->join('binh_luan', 'binh_luan.id_sanpham', '=', 'san_pham.id_sanpham') // Sửa bảng theo quan hệ đúng
            ->select('binh_luan.id_sanpham', 'binh_luan.noidung', 'binh_luan.danhgia')
            ->paginate(10);

        return view('users.pages.profile', compact('user', 'favorites', 'scores'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Logic cập nhật thông tin người dùng (nếu có)
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Logic xóa người dùng hoặc các sản phẩm yêu thích, đánh giá, nếu cần
    }

    /**
     * Show the favorite products page.
     */
    public function favorite()
    {
        return view('users.profile.favorite'); // Trả về view cho trang Favorites
    }

    /**
     * Show the score page.
     */
    public function score()
    {
        return view('users.profile.score'); // Trả về view cho trang Score (đánh giá)
    }
}
