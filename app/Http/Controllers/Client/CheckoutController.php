<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CheckoutController
{
    public function index()
    {
        return view('users.pages.checkout');
    }
}
