@extends('layout.master')

@section('content')
<title>Login | {{ config('app.name') }}</title>

<style>
    .alert {
        background: cornflowerblue;
    }
</style>

@if (session()->has('success'))
    <div class="alert alert-success text-center">{{ session()->get('success') }}</div>
@endif
@if (session()->has('error'))
    <div class="alert alert-danger text-center">{{ session()->get('error') }}</div>
@endif

<div class="container d-flex justify-content-center align-items-center" style="min-height: 50vh;">
    <div class="row w-100">
        <div class="col-md-4 offset-md-4">
            @auth
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Logout</button>
                    </div>
                </form>
            @endauth

            @guest
                <form action="{{ route('login.auth') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <input type="email" class="form-control" name="email" placeholder="Email" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" name="password" placeholder="Password" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-danger">Login</button>
                    </div>
                </form>
            @endguest
        </div>
    </div>
</div>
@endsection
