<?php
namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Models\NguoiDung;
use Illuminate\Routing\Controller;
class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = NguoiDung::findOrFail(2);
        // Lấy người dùng hiện tại đang đăng nhập
        // $user = Auth::user();
        return view('users.pages.profile', compact('user'));
    }
    


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        $user = NguoiDung::findOrFail($id);
        return view('profile.show', compact('user'));
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
        // $request->validate([
        //     'hoten' => 'required|max:255',
        //     'email' => 'required|email',
        //     'sodienthoai' => 'required|digits_between:10,11',
        //     'diachi' => 'nullable|max:255',
        //     'gioitinh' => 'required|in:0,1',
        //     'ngaysinh' => 'nullable|date',
        //     'avatar' => 'nullable|image|max:2048',
        // ]);
    
        // $user = NguoiDung::findOrFail($id);
        // $user->update($request->all());
    
        // if ($request->hasFile('avatar')) {
        //     $avatarPath = $request->file('avatar')->store('avatars', 'public');
        //     $user->avatar = $avatarPath;
        //     $user->save();
        // }
    
        // return redirect()->route('profile.show', $user->id_nguoidung)->with('success', 'Cập nhật thành công!');
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
