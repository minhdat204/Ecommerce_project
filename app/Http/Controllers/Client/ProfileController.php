<?php
namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Models\FavoriteProduct;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $user = User::findOrFail(3); // Đây có thể được thay thế bằng Auth::user() nếu sử dụng tính năng đăng nhập.
        // Lấy các sản phẩm yêu thích của người dùng (ID = 4)
        $favorites = FavoriteProduct::where('id_nguoidung', $user->id_nguoidung)
            ->join('san_pham', 'san_pham.id_sanpham', '=', 'san_pham_yeu_thich.id_sanpham')
            ->select('san_pham.id_sanpham', 'san_pham.tensanpham', 'san_pham.gia')
            ->paginate(10); 
        $scores = Comment::with('product') 
            ->where('id_nguoidung', $user->id_nguoidung)
            ->select('noidung', 'id_sanpham','danhgia') 
            ->paginate(10);
        return view('users.pages.profile', compact('user', 'favorites', 'scores'));
    }

    /**
     * Show the profile of a specific user.
     */
    public function show($userId)
    {
       
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
