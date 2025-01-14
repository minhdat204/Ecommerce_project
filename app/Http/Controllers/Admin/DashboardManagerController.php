<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use App\Models\WebsiteInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
                    'phone' => 'required|string|max:10',
                    'email' => 'required|email',
                    'content' => 'required|string',
                    'facebook_link' => 'nullable|url|max:255', // Validate link Facebook
                    'logo_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // Validate logo (ảnh)
                ]);

                $websiteInfo = WebsiteInfo::first();
                if (!$websiteInfo) {
                    $websiteInfo = new WebsiteInfo();
                }

                $websiteInfo->address = $request->address;
                $websiteInfo->phone = $request->phone;
                $websiteInfo->email = $request->email;
                $websiteInfo->content = $request->content;
                $websiteInfo->facebook_link = $request->facebook_link;

                if ($request->hasFile('logo_image')) {
                    if ($websiteInfo->logo_image && Storage::exists($websiteInfo->logo_image)) {
                        Storage::delete($websiteInfo->logo_image);
                    }

                    $path = $request->file('logo_image')->store('logos', 'public');
                    $websiteInfo->logo_image = $path;
                }

                $websiteInfo->save();

                return redirect()->route('admin.dashboard.index')
                    ->with('success', 'Thông tin website đã được cập nhật thành công.');
            }




}
