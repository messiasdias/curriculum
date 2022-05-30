<!-- Page header -->
<div class="page-top-section @if($nomepg == 'Soluções') mb-0 @endif">
	<div class="container">
		<div class="row">

			<div class="page-info @if (!is_null($breadcase) && $breadcase) breadcase @endif col-lg-6">
				<h2>{{ $breadcrumb }}</h2>
				<div class="page-links">
					<a title="Ir para a inicial" href="{{ url('/home') }}">Inicial</a>
					<span>{{ $nomepg }}</span>
				</div>
			</div>

		</div>
	</div>
</div>
<!-- Page header end-->