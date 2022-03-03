<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>AdminLTE 3 | Dashboard</title>

	<meta name="csrf-token" content="{{ csrf_token() }}">

	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="{{ asset('/theme/plugins/fontawesome-free/css/all.min.css') }}">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<!-- Tempusdominus Bootstrap 4 -->
	<link rel="stylesheet" href="{{ asset('/theme/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
	<!-- iCheck -->
	<link rel="stylesheet" href="{{ asset('/theme/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
	<!-- JQVMap -->
	<link rel="stylesheet" href="{{ asset('/theme/plugins/jqvmap/jqvmap.min.css') }}">
	<!-- Theme style -->
	<link rel="stylesheet" href="{{ asset('/theme/dist/css/adminlte.min.css') }}">
	<!-- overlayScrollbars -->
	<link rel="stylesheet" href="{{ asset('/theme/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
	<!-- Daterange picker -->
	<link rel="stylesheet" href="{{ asset('/theme/plugins/daterangepicker/daterangepicker.css') }}">
	<!-- summernote -->
	<link rel="stylesheet" href="{{ asset('/theme/plugins/summernote/summernote-bs4.min.css') }}">

	<link rel="stylesheet" href="{{ asset('/css/app.css') }}">

	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
		
	<script type="text/javascript">
		// function playnotifictionsound()
		// {
		   
		//    	var el = document.getElementById('notificationaudio');
		// 	  var playPromise = el.play();

		// 	  if (playPromise !== undefined) {
		// 	    playPromise.then(_ => {
		// 	      // Automatic playback started!
		// 	      // Show playing UI.
		// 	    })
		// 	    .catch(error => {
		// 	      // Auto-play was prevented
		// 	      // Show paused UI.
		// 	      playnotifictionsound();
		// 	    });
		// 	  }
		// }
	</script>
	@livewireStyles

	@livewireScripts

</head>
<body class="hold-transition sidebar-mini layout-fixed">
	<div class="wrapper">

		<!-- Preloader -->
		{{-- <div class="preloader flex-column justify-content-center align-items-center">
		  <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
		</div> --}}

		@include('navigation-menu')
		@include('sidemenu')

	{{-- <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
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
						<a class="nav-link" href="{{ url('/inbox') }}">Inbox</a>
						
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
	</nav> --}}
	<div class="content-wrapper">
		@yield('page_header')
		<section class="content">
			<div class="container-fluid pt-2">
				@yield('container')
			</div>
		</section>
	</div>

	{{-- <div class="content-wrapper">
		<section class="content">
			<div class="container-fluid">
			@yield('container')
			</div>
		</section>
	</div> --}}

	<!-- <audio id="notificationaudio" preload="none" src="audio_notification.mp3"></video> -->


	<!-- jQuery -->
	<script src="{{ asset('/theme/plugins/jquery/jquery.min.js') }}"></script>
	<!-- jQuery UI 1.11.4 -->
	<script src="{{ asset('/theme/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
	<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
	<script>
	$.widget.bridge('uibutton', $.ui.button)
	</script>
	<!-- Bootstrap 4 -->
	<script src="{{ asset('/theme/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
	<!-- ChartJS -->
	<script src="{{ asset('/theme/plugins/chart.js/Chart.min.js') }}"></script>
	<!-- Sparkline -->
	<script src="{{ asset('/theme/plugins/sparklines/sparkline.js') }}"></script>
	<!-- JQVMap -->
	<script src="{{ asset('/theme/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
	<script src="{{ asset('/theme/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
	<!-- jQuery Knob Chart -->
	<script src="{{ asset('/theme/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
	<!-- daterangepicker -->
	<script src="{{ asset('/theme/plugins/moment/moment.min.js') }}"></script>
	<script src="{{ asset('/theme/plugins/daterangepicker/daterangepicker.js') }}"></script>
	<!-- Tempusdominus Bootstrap 4 -->
	<script src="{{ asset('/theme/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
	<!-- Summernote -->
	<script src="{{ asset('/theme/plugins/summernote/summernote-bs4.min.js') }}"></script>
	<!-- overlayScrollbars -->
	<script src="{{ asset('/theme/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
	<!-- AdminLTE App -->
	<script src="{{ asset('/theme/dist/js/adminlte.js') }}"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="{{ asset('/theme/dist/js/demo.js') }}"></script>

	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/3.4.1/select2.min.css">
	<script src="//cdnjs.cloudflare.com/ajax/libs/rangy/1.2.3/rangy-core.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/3.4.1/select2.min.js"></script>
	<link rel="stylesheet" href="{{ asset('/mention/mentions-kinder.css') }}">
	<script src="{{ asset('/mention/mentions-kinder.min.js') }}"></script>
	<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
	{{-- <script src="{{ asset('/theme/dist/js/pages/dashboard.js') }}"></script> --}}

	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

	<link rel="stylesheet" href="{{ asset('theme/plugins/summernote/summernote-bs4.min.css') }}">
	<script src="{{ asset('theme/plugins/summernote/summernote-bs4.min.js') }}"></script>

	
	<script src="{{ asset('js/app.js?v='.time()) }}"></script>
	<script src="{{ asset('js/users.js?v='.time()) }}"></script>
	<script type="text/javascript">
		Echo.private(`me`)
          .listen('.User', (e) => {
            console.log("ok");
              console.log(e);
        });
	</script>
	@stack('custom-scripts')
</body>

</html>