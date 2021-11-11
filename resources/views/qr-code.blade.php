<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="{{ asset('/favicon.png') }}">
	<title>DeliverSystem</title>

	<!-- Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

	<!-- Styles -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.5.10/clipboard.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
	<!-- <link href="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" /> -->
	<style>
		/* .link {
                font-weight: 300;
                font-size: large;
                height: 20%;
                width: 20%;
                border: solid 1px grey;
                border-radius: 10px;
                margin: 20px;
                color: black !important;
            } */
	</style>
</head>

<body>
	<div id="app">
		<nav class="navbar navbar-default navbar-static-top custom-navbar">
			<div class="container">
				<div class="navbar-header">

					<!-- Collapsed Hamburger -->
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
						<span class="sr-only">Toggle Navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>

					<!-- Branding Image -->
					<a class="navbar-brand" href="{{ url('/') }}">
						{{ config('app.name', 'Laravel') }}
					</a>
				</div>

				<div class="collapse navbar-collapse" id="app-navbar-collapse">
					<!-- Left Side Of Navbar -->
					<ul class="nav navbar-nav">
						&nbsp;
					</ul>

					<!-- Right Side Of Navbar -->
					<ul class="nav navbar-nav navbar-right">
						<!-- Authentication Links -->
						@guest
						<li><a href="{{ route('login') }}">Login</a></li>
						<li><a href="{{ route('register') }}">Register</a></li>
						@else
						<li><a href="{{ route('admin.qrcode.index') }}">QR Code</a></li>

						<li>
							<a href="{{ route('admin.index') }}">Home</a>
							<!-- <router-link :to="{ name: 'lockerSetting' }">Locker</router-link> -->
						</li>
						<!-- <li>
							<router-link :to="{ name: 'apartSetting' }">Apartment</router-link>
						</li> -->
						<!-- <li><a href="{{ url('/admin/companies/lockersetting') }}">Locker</a></li> -->
						<!-- <li><a href="{{ url('/admin/companies/apartsetting') }}">Apartment</a></li> -->
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
								{{ Auth::user()->name }} <span class="caret"></span>
							</a>

							<ul class="dropdown-menu" role="menu">
								<li>
									<a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
										Logout
									</a>

									<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
										{{ csrf_field() }}
									</form>
								</li>
							</ul>
						</li>
						@endguest
					</ul>
				</div>
			</div>
		</nav>
		<div class="flex-center position-ref full-height">
			<!-- @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            @endif -->

			<div class="content">
				<div class="text-center">
					<h3> Courier QR Code </h3>

					<div class="qrcode-container">
						<img class="qrcode--fancy" src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->errorCorrection('H')->size(200)->generate($unique)) !!}" />
					</div>
					<br>

					<div id="qrcode-container">
						<span id="qrcode-url">{{$unique}}</span>
						<button id="qrcode-copy" data-clipboard-text="{{$unique}}"> <img style="width: 15px;" src="img/clippy.svg" alt="Copy to clipboard"></button>
					</div>
					<!-- //TODO FIX THE DEPART NUMBER
				-->
					<form class="form-horizontal" action="{{ route('admin.qrcode.download', [ 'type' => 'png', 'url' => $unique, 'depart'=>1 ])}}" method="post">
						@csrf
						<button type="submit" class="btn btn-success btn--margin">
							<i class="fas fa-fw fa-download"></i>
							Download as PNG
						</button>

					</form>

					<!-- <ul class="d-flex p-0 justify-content-center" style="list-style:none;">
						<li>
							<form class="form-horizontal" action="{{ route('admin.qrcode.download', [ 'type' => 'png' ])}}" method="post">
								@csrf
								<button type="submit" class="align-middle btn btn-outline-primary btn-sm">
									<i class="fas fa-fw fa-download"></i>
									PNG
								</button>
							</form>
						</li>
						<li>
							<form class="form-horizontal" action="{{ route('admin.qrcode.download', [ 'type' => 'svg' ])}}" method="post">
								@csrf
								<button type="submit" class="align-middle btn btn-outline-primary btn-sm ml-1">
									<i class="fas fa-fw fa-download"></i>
									SVG
								</button>
							</form>
						</li>
						<li>
							<form class="form-horizontal" action="{{ route('admin.qrcode.download',[ 'type' => 'eps' ])}}" method="post">
								@csrf
								<button type="submit" class="align-middle btn btn-outline-primary btn-sm ml-1">
									<i class="fas fa-fw fa-download"></i>
									EPS
								</button>
							</form>
						</li>
					</ul> -->
				</div>

				<!-- <router-view name="firstScreen"></router-view>
            @yield('content') -->

				<!-- 
                <div class="title m-b-md">
                    Laravel
                </div>

                <div class="links">
                    <a href="https://laravel.com/docs">Documentation</a>
                    <a href="https://laracasts.com">Laracasts</a>
                    <a href="https://laravel-news.com">News</a>
                    <a href="https://forge.laravel.com">Forge</a>
                    <a href="https://github.com/laravel/laravel">GitHub</a>
                </div> -->
			</div>


		</div>
	</div>
	<script>
		$('#qrcode-copy').tooltip({
			trigger: 'click',
			placement: 'bottom'
		});

		function setTooltip(message) {
			$('#qrcode-copy').tooltip('hide')
				.attr('data-original-title', message)
				.tooltip('show');
		}

		function hideTooltip() {
			setTimeout(function() {
				$('#qrcode-copy').tooltip('hide');
			}, 1000);
		}

		// Clipboard

		var clipboard = new Clipboard('#qrcode-copy');

		clipboard.on('success', function(e) {
			setTooltip('Copied!');
			hideTooltip();
		});

		clipboard.on('error', function(e) {
			setTooltip('Failed!');
			hideTooltip();
		});

		function test() {
			var data = document.getElementById('qrcode-url').innerText;
			navigator.clipboard.writeText(data);
			// document.execCommand('copy');
		}
	</script>
	<!-- <script src="{{ mix('js/app.js') }}"></script> -->
	<!-- <script src="{{ asset('js/app.js') }}"></script> -->
</body>

</html>