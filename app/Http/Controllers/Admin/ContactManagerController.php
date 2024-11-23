<?php

namespace App\Http\Controllers\Admin;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactManagerController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $contacts = Contact :: with ('user') 
        -> select ('id_lienhe', 'ten', 'email', 'sodienthoai', 'noidung', 'trangthai', 'id_nguoidung')
        -> paginate (10);
        return view('admin.pages.contact.index', compact('contacts'));
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
        $contacts = Contact::find($id);

        if ($contacts) {
            $contacts->delete();
            return redirect()->route('admin.contact.index')->with('success', 'Liên hệ đã được xóa');
        }
    
        return redirect()->route('admin.contact.index')->with('error', 'Không tìm thấy liên hệ');
    }
}
