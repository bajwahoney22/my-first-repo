@extends('layout.master')
@section('content')
    <div class="container">
        <h1 class="mt-5">Cart Items</h1>

        @if ($cartItems->isEmpty())
            <p>Your cart is empty.</p>
        @else
            <table class="table table-bordered mt-5" style="margin-bottom: 20%">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cartItems as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>
                                <div class="input-group">
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <div class="input-group">
                                            <button type="submit" name="action" value="decrease"
                                                class="btn btn-outline-secondary">-</button>
                                            <input type="number" name="qty" value="{{ $item->qty }}"
                                                class="form-control text-center" readonly>
                                            <button type="submit" name="action" value="increase"
                                                class="btn btn-outline-secondary">+</button>
                                        </div>
                                    </form>
                                </div>
                            </td>
                            <td>${{ number_format($item->product->price, 2) }}</td>
                            <td>${{ number_format($item->qty * $item->product->price, 2) }}</td>
                            <td>
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Checkout Button -->
            <div class="d-flex justify-content-start" style="margin-bottom: 100px">
                <a href="{{ route('checkout.index') }}" class="btn btn-primary">Proceed to Checkout</a>
            </div>
        @endif
    </div>
@endsection
