@extends('layout.master')
@section('content')
    <style>
        table,
        thead,
        tbody,
        th,
        td {
            border: 5px solid black;
            
        }
    </style>
    <a href="{{ route('product.create') }}" class="btn btn-primary mt-5 mb-5">Add New</a>
    <div style="margin-bottom: 15%">
        <table class="table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Category</th>
                    <th>Thumbnail</th>
                    <th>Brand</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Size</th>
                    <th>Update</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->category?->name }}</td>
                        <td><img src="{{ asset("storage{$product->thumbnail}") }}" alt="Thumbnail not found" style="width: 70px" loading="lazy"></td>
                        <td>{{ $product->brand?->name }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->size }}</td>
                        <td>
                            <a href="{{ route('product.edit', ['id' => $product->id]) }}" class="btn btn-warning">Edit</a>
                            <button class="btn btn-danger" type="button"
                                onclick="deleteProduct({{ $product->id }})">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $products->links() }}
        <form action="#" method="POST" id="deleteProductForm">
            @csrf
            @method('DELETE')
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        function deleteProduct(id) {
            const decision = confirm("Are you sure you want to delete the record?\nEither OK or Cancel.");
            if (decision) {
                const form = document.getElementById('deleteProductForm');
                form.action = `/product/${id}/destroy`;
                form.submit();
            }
        }
    </script>
@endpush
