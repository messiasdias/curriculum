<!doctype html>
<html lang="pt-br">
	@php $public_path = !is_null($public) && $public ? 'public/' : '' @endphp

	@include('includes.head')
	<body>
		<div id="main-wrapper">

			@include('includes.header')

			@if(!is_null($home) && $home) @include('includes.breadcrumb') @endif

			<div id="site">@yield('content')</div>

		    @include('includes.footer')

	    </div>

		<!--====== Javascripts & Jquery ======-->
		<script src="{{ asset("{$public_path}js/jquery-2.1.4.min.js") }}"></script>
		<script src="{{ asset("{$public_path}js/bootstrap.min.js") }}"></script>
		<script src="{{ asset("{$public_path}js/magnific-popup.min.js") }}"></script>
		<script src="{{ asset("{$public_path}js/owl.carousel.min.js") }}"></script>
		<script src="{{ asset("{$public_path}js/circle-progress.min.js") }}"></script>
		<script src="{{ asset("{$public_path}/admin/libs/sweetalert2/sweetalert2.min.js") }}" ></script>
		<script src="{{ asset("{$public_path}js/app.js") }}"></script>
		<script src="{{ asset("{$public_path}js/main.js") }}"></script>
	</body>
</html>