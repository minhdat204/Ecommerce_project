<?php

namespace App\Http\Controllers\Client;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $slider = Product::where('trangthai', 'active')
            ->where(function($query) {
                $query->whereNotNull('gia_khuyen_mai')
                      ->orWhere('luotxem', '>', 100);
            })
            ->with('images')
            ->limit(3)
            ->get();
        return view('users.pages.home', compact('slider'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
