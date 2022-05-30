<!doctype html>
<html lang="pt-br">
    @php $public_path = !is_null($public) && $public ? 'public/' : '' @endphp

	@include('cms.includes.head')
    <body data-sidebar="dark" class="auth-body-bg">
        @if (session('status')) <script> localStorage.setItem('sessionStatus', "{{ session('status') }}"); </script> @endif

        <!-- Begin page -->
        <div id="layout-wrapper">@yield('content')</div>

        @include('cms.includes.footer')
    </body>
</html>