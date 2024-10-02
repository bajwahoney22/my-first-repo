<nav class="custom-navbar navbar navbar navbar-expand-md navbar-dark bg-dark" arial-label="Furni navigation bar">

    <div class="container">
        {{-- <a class="navbar-brand" href="index.html">Furni<span>.</span></a> --}}

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsFurni" aria-controls="navbarsFurni" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsFurni">
            <ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
                <li class="nav-item active">
                    <a class="nav-link" href="{{ url('/') }}">Home</a>
                </li>
                {{-- <li><a class="nav-link" href="{{ url('shop') }}">Shop</a></li>
                <li><a class="nav-link" href="{{ url('about') }}">About us</a></li>
                <li><a class="nav-link" href="{{ url('services') }}">Services</a></li>
                <li><a class="nav-link" href="{{ url('blog') }}">Blog</a></li>
                <li><a class="nav-link" href="{{ url('contact') }}">Contact us</a></li> --}}
                <li><a class="nav-link" href="{{ route('product.index') }}">product</a></li>
                <li><a class="nav-link" href="{{ route('categories.index') }}">Categories</a></li>
                <li><a class="nav-link" href="{{ route('brands.index') }}">Brands</a></li>
                <li><a class="nav-link" href="{{ route('index') }}">Filter Data</a></li>
                <li><a class="nav-link" href="{{ route('cart.index') }}">cart</a></li>
                <li><a class="nav-link" href="{{ route('user.create') }}">Register</a></li>
                <li><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                <li><a class="nav-link" href="{{ route('forget.request') }}">Forget Password</a></li>
            </ul>

            <ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5">
                <li><a class="nav-link" href="#"><img src="{{ asset('assets/images/user.svg') }}"></a></li>
                <li><a class="nav-link" href="{{ url('cart') }}"><img src="{{ asset('assets/images/cart.svg') }}"></a></li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">Logout</button>
                  </form>
            </ul>
        </div>
    </div>
        
</nav>