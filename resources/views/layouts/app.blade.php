<!DOCTYPE html>
<html lang="cs" class="no-js">

<head>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

	<!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
	<!-- Favicon-->
	<link rel="shortcut icon" href="img/fav.png">
    
    <!-- Author Meta -->
	<meta name="author" content="CodePixar">
    
    <!-- Meta Description -->
	<meta name="description" content="">
    
    <!-- Meta Keyword -->
	<meta name="keywords" content="">
    
    <!-- meta character set -->
	<meta charset="UTF-8">
    
    <!-- Site Title -->
	<title>{{ config('app.name', 'Pazi') }}</title>

	<link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i|Roboto:400,500" rel="stylesheet">
    <!--CSS============================================= -->
    <link href="{{ asset('css/linearicons.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/availability-calendar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/magnific-popup.css') }}" rel="stylesheet">
    <link href="{{ asset('css/nice-select.css') }}" rel="stylesheet">
    <link href="{{ asset('css/owl.carousel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-datepicker.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
	
</head>

<body>

	<!--================ Start Header Area =================-->
	<header class="header-area">
		<div class="container">
			<div class="header-wrap">
				<div class="header-top d-flex justify-content-between align-items-center navbar-expand-md">
					<div class="col menu-left">
						<a href="{{ url('/home') }}">O nás</a>
						
						<a href="{{ url('/sortiment') }}">Sortiment</a>
					</div>
					<div class="col-3 logo">
						<a href="{{ url('/home') }}"><img class="mx-auto" src="img/logo.png" alt="Logo"></a>
					</div>
					<nav class="col navbar navbar-expand-md justify-content-end">

						<!-- Toggler/collapsibe Button -->
						<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
							<span class="lnr lnr-menu"></span>
						</button>

						<!-- Navbar links -->
						<div class="collapse navbar-collapse menu-right" id="collapsibleNavbar">
							<ul class="navbar-nav justify-content-center w-100">
								<li class="nav-item hide-lg">
									<a class="nav-link" href="{{ url('/home') }}">O nás</a>
								</li>
								<li class="nav-item hide-lg">
									<a class="nav-link" href="{{ url('/sortiment') }}">Sortiment</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="{{ url('/objednat') }}">Objednat</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="{{ url('/kontakt') }}">Kontakt</a>
								</li>
								@if(Auth::check())
									<li class="nav-item">
										<a class="nav-link" href="{{ url('/administrace') }}">Administrace</a>
									</li>
								@endif
							</ul>
						</div>
					</nav>
				</div>
			</div>
		</div>
	</header>	

	@if ($errors->any())
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif

	@if ($message = Session::get('success'))
		<div class="alert alert-success alert-block">
			<button type="button" class="close" data-dismiss="alert">×</button>	
				<strong>{{ $message }}</strong>
		</div>
	@endif


	@if ($message = Session::get('error'))
		<div class="alert alert-danger alert-block">
			<button type="button" class="close" data-dismiss="alert">×</button>	
				<strong>{{ $message }}</strong>
		</div>
	@endif


	@if ($message = Session::get('warning'))
		<div class="alert alert-warning alert-block">
			<button type="button" class="close" data-dismiss="alert">×</button>	
			<strong>{{ $message }}</strong>
		</div>
	@endif


	@if ($message = Session::get('info'))
		<div class="alert alert-info alert-block">
			<button type="button" class="close" data-dismiss="alert">×</button>	
			<strong>{{ $message }}</strong>
		</div>
	@endif

	@if(!session('cookie'))
		<div id="cookie">
			Pro pohodlný nákup používáme cookies. 
		
			{{ Form::open(['action' => 'HomeController@cookie', 'class' => 'form-group']) }}
					
				{{ Form::submit('Rozumím', ['class' => 'genric-btn primary e-large']) }}
				
			{{ Form::close() }}
		</div>
	@endif

    @yield('content')
	
	<!--================ Start Footer Area =================-->
	<footer class="footer-area section-gap">
		<div class="container">
			<div class="row">
				<div class="col-lg-5 col-md-2 col-sm-2">
					<div class="single-footer-widget">
						<h4>Otevírací doba</h4>
						<ul>
							<li>Po - 8:00 - 12:00</li>
							<li>Út - 8:00 - 12:00</li>
							<li>St - 8:00 - 12:00</li>
                            <li>Čt - 8:00 - 12:00</li>
                            <li>Pá - 8:00 - 12:00</li>
                            <li>So - 8:00 - 12:00</li>
                            <li>Ne - 8:00 - 12:00</li>
						</ul>
					</div>
				</div>
				
				<div class="col-lg-5 col-md-2 col-sm-2">
					<div class="single-footer-widget">
						<h4>Adresa</h4>
						<ul>
							<li>Ulice</li>
							<li>Hradec Králové</li>
						</ul>
					</div>
				</div>				
			</div>
			<div class="footer-bottom row align-items-center justify-content-between">
				<p class="footer-text m-0 col-lg-6 col-md-12">Copyright © 2019 Všechna práva vyhrazena | This template is made with
					<span class="lnr lnr-heart"></span> by <a href="#">Colorlib</a></p>
				<div class="col-lg-6 col-sm-12 footer-social">
					<a href="#"><i class="fa fa-facebook"></i></a>
					<a href="#"><i class="fa fa-twitter"></i></a>
					<a href="#"><i class="fa fa-instagram"></i></a>
				</div>
			</div>
		</div>
	</footer>
    <!--================ End Footer Area =================-->
    
    <script src="{{ asset('js/vendor/jquery-2.2.4.min.js') }}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="{{ asset('js/vendor/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/jquery.sticky.js') }}"></script>
    <script src="{{ asset('js/parallax.min.js') }}"></script>
    <script src="{{ asset('js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('js/jquery.ajaxchimp.min.js') }}"></script>
    <script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhOdIF3Y9382fqJYt5I_sswSrEw5eihAA"></script>
    <script src="{{ asset('js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
	
</body>

</html>