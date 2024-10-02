<!doctype html>
<html lang="en">
<head>
  
		@include('partials.head')
	</head>

	<body>

		<!-- Start Header/Navigation -->
		
		@include('partials.navbar')
		<!-- End Header/Navigation -->

		@yield('content')

		<!-- Start Footer Section -->
		
		@include('partials.footer')
		<!-- End Footer Section -->	


		
		@include('partials.script')
		@stack('scripts')
	</body>

</html>
