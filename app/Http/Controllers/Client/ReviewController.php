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
public function checkCanReview($productId)
    {
        $userId = Auth::id();

        // Đếm số lần mua sản phẩm đã hoàn thành
        $purchaseCount = Order::from('don_hang')
            ->join('chi_tiet_don_hang', 'don_hang.id_donhang', '=', 'chi_tiet_don_hang.id_donhang')
            ->where('don_hang.id_nguoidung', $userId)
            ->where('chi_tiet_don_hang.id_sanpham', $productId)
            ->where('don_hang.trangthai', 'completed')
            ->count();

        // Đếm số lần đã đánh giá
        $reviewCount = Comment::where('id_sanpham', $productId)
            ->where('id_nguoidung', $userId)
            ->count();

        // Kiểm tra xem còn lượt đánh giá không
        $canReview = $purchaseCount > $reviewCount;

        return [
            'canReview' => $canReview,
            'message' => $purchaseCount == 0 ?
                'Bạn cần mua sản phẩm trước khi đánh giá' : ($canReview ? null : 'Bạn đã đánh giá ')
        ];
    }    public function store(Request $request)
    {
        // Validate dữ liệu từ form
        $validatedData = $request->validate([
            'id_sanpham' => 'required|exists:san_pham,id_sanpham',
            'danhgia' => 'required|integer|min:1|max:5',
            'noidung' => 'required|string|max:1000',
        ]);

        try {
            $userId = Auth::id();

            // Kiểm tra điều kiện đánh giá
            $checkResult = $this->checkCanReview($request->id_sanpham);
            if (!$checkResult['canReview']) {
                return redirect()->back()->with('error', $checkResult['message']);
            }

            // Thêm đánh giá vào cơ sở dữ liệu
            Comment::create([
                'id_sanpham' => $request->id_sanpham,
                'id_nguoidung' => $userId,
                'danhgia' => $request->danhgia,
                'noidung' => $request->noidung,
            ]);

            return redirect()->back()->with('success', 'Đánh giá đã được gửi.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra. Vui lòng thử lại.');
        }
    }
}
