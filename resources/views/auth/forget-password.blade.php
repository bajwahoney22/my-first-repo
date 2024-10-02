@extends('layout.master')
<title>Forget Password | {{ config('app.name') }}</title>
@section('content')
    <div class="d-flex justify-content-center align-items-center" style="height: 40vh;">
        <form action="{{ route('forget.email') }}" method="POST" class="text-center">
            @csrf
            <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-secondary mt-3">Send</button>
        </form>
    </div>
@endsection