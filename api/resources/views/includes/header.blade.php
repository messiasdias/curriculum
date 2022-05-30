<!-- Header section -->
<header class="header-section">
	<div class="logo">
		<a href="{{ url('/home') }}" title="">
			<img src="@if(!is_null($public) && $public) {{ asset('public/img/speel.svg') }} @else {{ asset('/img/speel.svg') }} @endif" alt="">
		</a>
	</div>
	<!-- Navigation -->
	<div class="responsive"><i class="fa fa-bars"></i></div>
	<nav>

		<ul class="menu-list">
			<li class="logoresponsivo"><a href="{{ url('/home') }}" title=""><img src="@if(!is_null($public) && $public) {{ asset('public/img/speel.svg') }} @else {{ asset('/img/speel.svg') }} @endif" alt=""></a></li>
			<li class=""><a href="{{ url('/quem-somos') }}">Quem somos</a></li>
			<li class=""><a href="{{ url('/solucoes') }}">Soluções</a></li>
			<li class=""><a href="{{ url('/cases') }}">Cases</a></li>
			<li class=""><a href="{{ url('/contato') }}">Contato</a></li>
			<li class=""><a title="Simule sua econômia" class="orcamento" target="_blank" href="https://www.faturapositiva.com.br/auth/registration"><img src="@if(!is_null($public) && $public) {{ asset('public/img/calculator2.svg') }} @else {{ asset('img/calculator2.svg') }} @endif" alt="">Simule sua econômia</a></li>
		</ul>
	</nav>
</header>
<!-- Header section end -->