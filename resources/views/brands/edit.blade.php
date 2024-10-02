@extends('layout.master')

@section('content')
<div class="card mt-5" style="margin-bottom:10%">
    <form action="{{ route('brands.update', ['id' => $brand->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row mt-5">
            <div class="col-12 mb-3">
                <input type="text" name="name" class="form-control" value="{{ $brand->name }}" placeholder="Name">
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary d-block ms-auto">Save</button>
            </div>
        </div>
    </form>
</div>
@endsection
