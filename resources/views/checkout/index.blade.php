@extends('layout.master')
@section('content')
    <div class="container">
        <h1>Checkout</h1>

        @if ($cartItems->isEmpty())
            <p>Your cart is empty.</p>
        @else
            <table class="table table-bordered mt-5">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cartItems as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ $item->qty }}</td>
                            <td>${{ number_format($item->product->price, 2) }}</td>
                            <td>${{ number_format($item->qty * $item->product->price, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end"><strong>Total:</strong></td>
                        <td>
                            ${{ number_format($cartItems->sum(fn($item) => $item->qty * $item->product->price), 2) }}
                        </td>
                    </tr>
                </tfoot>
            </table>

            <div class="mt-4 mb-4">
                <p><strong>Total Price:</strong>
                    ${{ number_format($cartItems->sum(fn($item) => $item->qty * $item->product->price), 2) }}</p>
            </div>
            
             <!-- Checkout Form -->
    <div class="mt-5">
        <h2
            style="font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif">
            Checkout</h2>
        
        <form action="{{ route('cart.placeorder') }}" method="POST" style="margin-bottom: 10%">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required value="{{ old('name') }}">
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required value="{{ old('email') }}">
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="tel" class="form-control" id="phone" name="phone" required value="{{ old('phone') }}">
                @error('phone')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" required value="{{ old('address') }}">
                @error('address')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="postal_code" class="form-label">Postal Code</label>
                <input type="text" class="form-control" id="postal_code" name="postal_code" required value="{{ old('postal_code') }}">
                @error('postal_code')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        
            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Place order</button>
        </form>
        
    </div>
        @endif
    </div>
@endsection
