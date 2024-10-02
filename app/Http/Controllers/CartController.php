<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function store(Request $request)
    {
        $cart = Cart::where('product_id', $request->product_id)->first();

        if ($cart) {
            $cart->qty = $cart->qty + $request->qty;
            $cart->update();
        } else {
            $cart = new Cart();
            $cart->product_id = $request->product_id;
            $cart->qty = $request->qty;
            $cart->save();
        }

        return redirect()->back()->with('success', 'Product has been added to cart!');
    }
    public function index()
{
    $cartItems = Cart::with('product')->get(); 
    return view('cart.index', compact('cartItems'));
}

    public function getCartItems()
    {
        $cartItems = Cart::with('product')->get();
        return view('cart.index', ['cartItems' => $cartItems]);
    }

    public function remove(Request $request)
    {
        $cartItem = Cart::find($request->id);

        if ($cartItem) {
            $cartItem->delete();
            return 'Item removed from cart.';
        }

        return 'Item not found.';
    }
    public function destroy($id)
{
    // Find the cart item by its ID
    $cart = Cart::find($id);

    if ($cart) {
        // Delete the cart item
        $cart->delete();
        
        return redirect()->route('cart.index')->with('success', 'Item removed from cart.');
    }

    return redirect()->route('cart.index')->with('error', 'Item not found.');
}
public function update(Request $request, $id)
{
    $cartItem = Cart::find($id);

    if ($request->action == 'increase') {
        $cartItem->qty += 1;
    } elseif ($request->action == 'decrease' && $cartItem->qty > 1) {
        $cartItem->qty -= 1;
    }

    $cartItem->save();

    return redirect()->route('cart.index')->with('success', 'Cart updated successfully.');
}
//////
public function placeorder(Request $request)
{

    \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

    $user = $request->user(); // Assuming the user is authenticated

    // Validate the request data
    $request->validate([
       
        'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string',
            'address' => 'required|string|max:255',
            'postal_code' => 'required|string|max:30',
    ]);

    // Calculate the total amount based on cart items
    $total = 0;
    $cartItems = Cart::with('product')->get();
    foreach ($cartItems as $cartItem) {
        $total += $cartItem->qty * $cartItem->product->price;
    }

    // Convert the total to cents for Stripe
    $totalInCents = $total * 100;

    // Create Stripe Checkout Session
    $checkoutSession = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => $this->getLineItems($cartItems),
        'mode' => 'payment',
        'success_url' => route('checkout.success'),
        'cancel_url' => route('checkout.cancel'),
    ]);

    // Store order details temporarily
    $request->session()->put('order_data', [
        'name' => $request->name,
        'email' => $request->email,
        'address' => $request->address,
        'city' => $request->city,
        'postal_code' => $request->postal_code,
        'country' => $request->country,
        'total' => $total,
    ]);

    // Redirect to Stripe Checkout
    return redirect()->to($checkoutSession->url);
}

private function getLineItems($cartItems)
{
    $lineItems = [];
    foreach ($cartItems as $cartItem) {
        $lineItems[] = [
            'price_data' => [
                'currency' => 'usd',
                'product_data' => [
                    'name' => $cartItem->product->name,
                ],
                'unit_amount' => $cartItem->product->price * 100, // Amount in cents
            ],
            'quantity' => $cartItem->qty,
        ];
    }
    return $lineItems;
}

public function checkoutSuccess(Request $request)
{
    // Retrieve order data from session
    $orderData = $request->session()->get('order_data');
    
    
    // DB::beginTransaction();
    
    // Save order details
    $order = Order::create($orderData);
    
    // Save cart items to the order
    foreach (Cart::with('product')->get() as $cartItem) {
        //  dd('all');
         $order->items()->create([
             'product_id' => $cartItem->product_id,
             'quantity' => $cartItem->qty,
             'price' => $cartItem->product->price,
         ]);
     }

     
     // Clear the cart
     Cart::truncate();
    //  Cart::where('user_id', auth()->id())->delete();
    //  DB::commit();
  
//     $admin = User::where('is_admin', true)->first(); 
// $admin->notify(new OrderPlaced($order));
    toastr()->success('Order placed successfully!');
    return redirect()->route('thankyou');
}

public function checkoutCancel()
{
    toastr()->error('Payment was canceled.');
    return redirect()->route('home');
}


}
