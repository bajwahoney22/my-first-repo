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
        <a href="{{ route('brands.create') }}" class="btn btn-primary mt-5 mb-5">Add New</a>
    <div style="margin-bottom: 15%">
        <table class="table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Products</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($brands as $data)
                    <tr>
                        <td>{{ $data->id }}</td>
                        <td>{{ $data->name }}</td>
                        <td>{{ $data->products_count }}</td>
                        <td>
                            <a href="{{ route('brands.edit', ['id' => $data->id]) }}" class="btn btn-warning">Edit</a>
                            <button class="btn btn-danger" type="button" onclick="deleteCategory({{ $data->id }})">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <form action="#" method="POST" id="deleteCategoryForm">
            @csrf
            @method('DELETE')
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        function deleteCategory(id) {
            const decision = confirm("Are you sure you want to delete the record?\nEither OK or Cancel.");
            if (decision) {
                const form = document.getElementById('deleteCategoryForm');
                form.action = `/brand/${id}/destroy`;
                form.submit();
            }
        }
    </script>
@endpush
