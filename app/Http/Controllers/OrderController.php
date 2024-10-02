<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function store(Request $request)
    {
          // Log the request data
          Log::info('Request Data:', $request->all());

        // Ensure the user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')->withErrors('You must be logged in to place an order.');
        }
    
        // Validate the request data
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer',
            'total_price' => 'required|numeric',
        ]);
    
        // Automatically add the authenticated user's ID
        $validated['user_id'] = auth()->id();
    
        // Create a new order using mass assignment
        $order = Order::create($validated);
    
        // Redirect to the orders index page with a success message
        return redirect()->route('orders.index')->with('success', 'Order created successfully!');
    }
    
    public function success()
    {
        // You can pass any necessary data to the success view
        return view('order.success');
    }
}
