@extends('layout.master')

@section('content')
<div class="card mt-5">
    <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data" style="margin-bottom: 10%">
        @csrf
        <div class="row">
            <div class="col-12 mb-3">
                <select name="category_id" id="category_id"  class="form-select">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 mb-3">
                <select name="brand_id" id="brand_id"  class="form-select">
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                    @endforeach
                </select>
                
            </div>
            <div class="col-12 mb-3">
                <input type="text" name="name" class="form-control" placeholder="Name" required>
            </div>
            <div class="col-12 mb-3">
                <input type="number" name="price" class="form-control" placeholder="Price" required>
            </div>
            <div class="col-12 mb-3 ">
                <select name="size" class="form-select" required>
                    <option value="S">Small</option>
                    <option value="M">Medium</option>
                    <option value="L">Large</option>
                    <option value="XL">Extra Large</option>
                </select>
            </div>
            <div class="col-12 mb-3">
                <input type="file" name="thumbnail" class="form-control" required accept="image/png, image/gif, image/jpeg">
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary d-block ms-auto">Save</button>
            </div>
        </div>
    </form>
</div>
@endsection
