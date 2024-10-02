@extends('layout.master')
@section('content')
    <main class="flex-fill" style="margin-bottom: 10%">
        <div class="container mt-5">
            <div class="card text-center">
                <div class="card-header bg-success text-white">
                    <h5 class="card-title">Thank You!</h5>
                </div>
                <div class="card-body">
                    <h3 class="card-text">Thank you for shopping with us!</h3>
                    <p>We appreciate your business and hope you enjoy your purchase.</p>
                    <p>If you have any questions, please <a href="mailto:support@example.com">contact us</a>.</p>
                </div>
                <div class="card-footer text-muted">
                    <a href="{{ url('/') }}" class="btn btn-primary">Back to Home</a>
                </div>
            </div>
        </div>
    </main>
@endsection
