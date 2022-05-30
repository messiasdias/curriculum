@extends('template.layout')

@section('content')

<section class="cases_section">
	<div class="interna-cases container">
		<div class="row mb-5">
			<div class="col-12">
				<h2 class="mb-3">{{$caseItem->name}}</h2>
				<span><i class="fa fa-map-marker"></i> {{$caseItem->localization}}.</span>
			</div>
			<div class="col-12 mt-5">{!! $caseItem->text !!}</div>
		</div>
		
		@if ($caseItem->galery !== null)
			<div class="row galeria mb-5 mt-5">
				@foreach ($caseItem->galery as $item)
					@if($item->image)
						<div class="col-lg-4 d-flex">
							<a data-fancybox="gallery" href="@if(!is_null($public) && $public) {{ asset('public/'.$item->image->url) }} @else {{ asset($item->image->url) }} @endif" title="">
								<img src="@if(!is_null($public) && $public) {{ asset('public/'.$item->image->url) }} @else {{ asset($item->image->url) }} @endif" alt="">
							</a>
						</div>
					@endif
				@endforeach
			</div>
		@endif

		@if ($caseItem->video)
		<div class="row">
			<div class="col-12 vídeos">
				<iframe width="100%" height="700" src="{{$caseItem->video}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			</div>
		</div>
		@endif
	</div>
</section>

@endsection