<?php

namespace App\Http\Controllers\Client;

use App\Models\Contact;

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
        $request->validate([
            'ten' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'sodienthoai' => 'nullable|string|max:20', 
            'noidung' => 'required|string',
        ]);

        Contact::create([
            'id_nguoidung'=>NULL,
            'ten'=>$request->input('ten'),
            'email'=>$request-> input('email'),
            'sodienthoai'=>$request->input('sodienthoai', '000000000'),
            'noidung'=>$request->input('noidung'),
            'trangthai'=>'new',
        ]); 
        return view('users.pages.contact');
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
