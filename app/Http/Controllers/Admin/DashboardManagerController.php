<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use App\Models\WebsiteInfo;
use Illuminate\Http\Request;

class DashboardManagerController
{
    public function index()
    {
        // Get statistics
        $stats = [
            'products' => [
                'total' => Product::count(),
                'active' => Product::where('trangthai', 'active')->count(),
                'inactive' => Product::where('trangthai', 'inactive')->count()
            ],
            'users' => [
                'total' => User::count(),
                'new_today' => User::whereDate('created_at', today())->count(),
                'active' => User::where('trangthai', 'active')->count()
            ],
            'orders' => [
                'total' => Order::count(),
                'pending' => Order::where('trangthai', 'pending')->count(),
                'completed' => Order::where('trangthai', 'completed')->count()
            ]
        ];

        // Get website info
        $websiteInfo = WebsiteInfo::first();

        return view('admin.pages.dashboard.index', compact('stats', 'websiteInfo'));
    }

    public function updateWebsiteInfo(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email',
            'content' => 'required|string'
        ]);

        $websiteInfo = WebsiteInfo::first();
        if (!$websiteInfo) {
            $websiteInfo = new WebsiteInfo();
        }

        $websiteInfo->fill($request->all());
        $websiteInfo->save();

        return redirect()->route('admin.dashboard.index')
            ->with('success', 'Thông tin website đã được cập nhật thành công.');
    }
}
