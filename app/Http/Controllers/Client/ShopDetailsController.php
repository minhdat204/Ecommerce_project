<?php
namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Models\FavoriteProduct;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ShopDetailsController
{
    public function showProductDetails($id)
{
    $ratingData = $this->getRating($id);

    \Log::info($ratingData); 
    return view('users.pages.shop-details', [
        'ratingData' => $ratingData  
    ]);
}


    public function getRating($id_sanpham)
{
    $countFavorites = DB::table('san_pham_yeu_thich')->where('id_sanpham', $id_sanpham)->count();
    $averageRating = DB::table('san_pham_yeu_thich')->where('id_sanpham', $id_sanpham)->avg('id_yeuthich');

    \Log::info(['countFavorites' => $countFavorites, 'averageRating' => $averageRating]);

    return [
        'countFavorites' => $countFavorites,
        'averageRating' => $averageRating ?: 0,
    ];
}

}
