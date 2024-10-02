
@extends('layout.master')

<title>Register | {{ config('app.name') }}</title>

@section('content')
<style>
    .alert {
        padding: 0.5rem 1rem;
        background: #78c61e7e;
        font-weight: bold;
    }
    .login-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }
    .login-form {
        width: 100%;
        max-width: 400px;
        padding: 15px;
        background-color: #f8f9fa;
        border-radius: 8px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }
</style>

<style>
    .alert {
        background: cornflowerblue;
    }
</style>

@if (session()->has('success'))
<div class="alert text-center">{{ session()->get('success') }}</div>
@endif

<div class="container d-flex justify-content-center align-items-center" style="min-height: 50vh;">
    <div class="row w-100">
        <div class="col-md-6 offset-md-3 mb-5 mt-5">
            {{-- <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Name">
                    @error('name')
                    <div style="color: red">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email">
                    @error('email')
                    <div style="color: red">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" name="password" placeholder="Password">
                    @error('password')
                    <div style="color: red">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password">
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>
            </form> --}}
            <form action="{{ route('user.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Name" required>
                    @error('name')
                    <div style="color: red">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" required>
                    @error('email')
                    <div style="color: red">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                    @error('password')
                    <div style="color: red">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>
            </form>
            
        </div>
    </div>
</div>
@endsection

