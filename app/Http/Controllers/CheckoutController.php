<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    { 
        $cartItems = Cart::with('product')->get();
        return view('checkout.index', ['cartItems' => $cartItems]);
    } 

}
