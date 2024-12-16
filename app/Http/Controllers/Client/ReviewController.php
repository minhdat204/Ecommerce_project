<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Order;

use App\Models\Product;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        // Validate dữ liệu từ form
        $validatedData = $request->validate([
            'id_sanpham' => 'required|exists:san_pham,id_sanpham',
            'danhgia' => 'required|integer|min:1|max:5',
            'noidung' => 'required|string|max:1000',
        ]);

        try {
            $userId = Auth::id(); // Lấy ID người dùng hiện tại

            // Thêm đánh giá vào cơ sở dữ liệu
            Comment::create([
                'id_sanpham' => $request->id_sanpham,
                'id_nguoidung' => $userId,
                'danhgia' => $request->danhgia,
                'noidung' => $request->noidung,
            ]);

            // Thông báo thành công
            return redirect()->back()->with('success', 'Đánh giá đã được gửi.');
        } catch (\Exception $e) {
            // Bắt lỗi và hiển thị thông báo lỗi

            return redirect()->back()->with('error', 'Có lỗi xảy ra. Vui lòng thử lại.');
        }
    }
}
