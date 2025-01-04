<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\WebsiteInfo;
use Illuminate\Support\Facades\Hash;  // Đảm bảo rằng có dòng này


class FooterServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Chia sẻ thông tin website vào tất cả các view
        $websiteInfo = WebsiteInfo::first();  // Lấy thông tin website từ database

        // Nếu không có thông tin, tạo đối tượng WebsiteInfo mới (tránh null)
        View::share('websiteInfo', $websiteInfo ?: new WebsiteInfo());
    }
}
