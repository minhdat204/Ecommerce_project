<?php
namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Models\FavoriteProduct;
use App\Models\User;
use Illuminate\Routing\Controller;
class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::findOrFail(4);
        // Lấy người dùng hiện tại đang đăng nhập
        // $user = Auth::user();
        $favorites = FavoriteProduct::where('id_nguoidung', 4)
        ->join('san_pham', 'san_pham.id_sanpham', '=', 'san_pham_yeu_thich.id_sanpham')
        ->select('san_pham.id_sanpham', 'san_pham.tensanpham', 'san_pham.gia')
        ->paginate(10);  // Phân trang cho danh sách sản phẩm yêu thích

    return view('users.pages.profile', compact('user', 'favorites'));
    }
    


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }


    public function show($userId)
{
    $user = User::find($userId);

    if (!$user) {
        return redirect()->route('profile.index')->with('error', 'Người dùng không tồn tại');
    }

    // Lấy sản phẩm yêu thích của người dùng
    $favorites = FavoriteProduct::where('id_nguoidung', $userId)
        ->join('san_pham', 'san_pham.id_sanpham', '=', 'san_pham_yeu_thich.id_sanpham')
        ->select('san_pham.id_sanpham', 'san_pham.tensanpham', 'san_pham.gia', 'san_pham.image')
        ->paginate(10);

    return view('users.pages.profile', compact('user', 'favorites'));
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
    public function update(Request $request, $id)
    {
        
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function favorite()
    {
    // Thực hiện các logic cần thiết cho trang Favorites
        return view('users.profile.favorite'); // Trả về view cho trang Favorites
    }
}
// node : Sẽ làm cn Edit nếu có thời gian !.