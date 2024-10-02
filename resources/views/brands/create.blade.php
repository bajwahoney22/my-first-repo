@extends('layout.master')

@section('content')
    <div class="container">
        <div class="row mt-5" style="margin-bottom: 10%">
        <form action="{{ route('brands.store') }}" method="POST">
            @csrf
                <div class="col-12 mb-3">
                    <input type="text" name="name" class="form-control" placeholder="Name" required>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary d-block ms-auto">Save</button>
                </div>
            </div>
        </form>
    </div>
@endsection
