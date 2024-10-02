@extends('layout.master')

@section('content')
<div class="container mt-5">
    <h1>Products</h1>
    <form action="{{ route('index') }}" method="GET">
        <div class="row mb-3">
            <div class="col-md-3">
                <select name="category" class="form-select">
                    <option value="">Select Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="brand" class="form-select">
                    <option value="">Select Brand</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>

    <div class="row">
        @forelse ($products as $product)
            <div class="col-md-4 mb-3">
                <div class="card">
                    @if ($product->thumbnail)
                        <img src="{{ asset('storage/' . $product->thumbnail) }}" class="card-img-top" alt="{{ $product->name }}">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">Category: {{ $product->category->name }}</p>
                        <p class="card-text">Brand: {{ $product->brand->name }}</p>
                        <p class="card-text">Price: ${{ $product->price }}</p>
                        <p class="card-text">Size: {{ $product->size }}</p>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#cartModal{{ $product->id }}">
                            Add to Cart
                        </button>
                    </div>
                </div>
            </div>

            <!-- Bootstrap Modal for each product -->
            <div class="modal fade" id="cartModal{{ $product->id }}" tabindex="-1" aria-labelledby="cartModalLabel{{ $product->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="cartModalLabel{{ $product->id }}">Add {{ $product->name }} to Cart</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('cart.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <div class="mb-3">
                                    <label for="quantity{{ $product->id }}" class="form-label">Quantity</label>
                           
                                    <input type="number" class="form-control" id="quantity{{ $product->id }}" name="qty" value="1" min="1">
                                    {{-- <label for="quantity{{ $product->id }}" class="form-label">Quantity</label>
                           
                                    <input type="number" class="form-control" id="quantity{{ $product->id }}" name="qty" value="1" min="1"> --}}
                                </div>
                                <button type="submit" class="btn btn-primary">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p>No products found.</p>
        @endforelse
    </div>
</div>
{{-- {{ $products->links() }} --}}
@endsection
