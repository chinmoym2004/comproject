<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title></title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	<style>
		.select2-container{
			width:100% !important;
		}
		.modal{
			z-index:1050 !important;
		}

		#chatbox,#chatlist{
			min-height:500px;
			overflow:hidden;
		}
		.mt-20{
			margin-top:20px;
		}
	</style>
	@livewireStyles
	@livewireScripts
</head>
<body>
	<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
		<div class="container">
			<a class="navbar-brand" href="{{ url('/') }}">
				Collab & Comm
			</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
				<!-- Left Side Of Navbar -->
				<ul class="navbar-nav mr-auto">

				</ul>

				<!-- Right Side Of Navbar -->
				<ul class="navbar-nav ml-auto justify-content-end">
					<!-- Authentication Links -->
					@guest
						@if (Route::has('login'))
							<li class="nav-item">
								<a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
							</li>
						@endif

						@if (Route::has('register'))
							<li class="nav-item">
								<a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
							</li>
						@endif
					@else
						<a class="nav-link" href="{{ url('/chat-admins') }}">Chat</a>
						<a class="nav-link" href="{{ url('/forum-admins') }}">Forum</a>
						
						<div class="dropdown pull-right">
							<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
								{{ Auth::user()->name }}
							</button>
							<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
							<li>
								<a class="dropdown-item" href="{{ route('logout') }}"
									onclick="event.preventDefault();
												document.getElementById('logout-form').submit();">
									{{ __('Logout') }}
								</a>

								<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
									@csrf
								</form>
							</li>
							</ul>
						</div>
					@endguest
				</ul>
			</div>
		</div>
	</nav>
	<div class="container">
		@yield('container')
	</div>
	
	<script src="{{ asset('js/app.js') }}"></script>
	<script src="{{ asset('js/users.js') }}"></script>



</body>

</html>