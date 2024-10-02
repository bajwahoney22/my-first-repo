@extends('layout.master')
@section('content')
    <div class="card mt-5" style= "margin-bottom:10%">
        <form action="{{ route('product.update', ['id' => $product->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row mt-5">
                <div class="col-12 mb-3">
                    <input type="text" name="name" class="form-control" value="{{ $product->name }}" placeholder="Name"
                        required>

                </div>
                <div class="col-12 mb-3">
                    <input type="number" name="price" class="form-control" value="{{ $product->price }}"
                        placeholder="Price" required>
                </div>
                <div class="col-12 mb-3">
                    <select name="size" class="form-select" value="{{ $product->size }}" required>
                        <option value="S">Small</option>
                        <option value="M">Medium</option>
                        <option value="L">Large</option>
                        <option value="XL">Extra Large</option>

                    </select>
                </div>
                <div class="col-12 mb-3">
                    <input type="file" name="thumbnail" class="form-control" value="{{ $product->size }}"
                        accept="image/png, image/gif, image/jpeg">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary d-block ms-auto">Save</button>
                </div>
            </div>
        </form>
    </div>
    {{ $products->links() }}
@endsection
