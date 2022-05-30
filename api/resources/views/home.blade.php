
@extends('template.layout')
@section('content')
    <template>
        <home-sliders></home-sliders>
        <home-boxes>
            <template slot="investir_home">
                <div class="row investir_home">
                    <h2 class="marca">Speel</h2>
                    <div class="col-lg-4">
                        <img loading="lazy" src="@if(!is_null($public) && $public) {{ asset('public/img/economia.png') }} @else {{ asset('/img/economia.png') }} @endif" class="economia" alt="">
                        <h2 class="mb-3">Investir<br> no futuro</h2>
                        <h3>
                            É investir<br>
                            em energia<br>
                            renovável.
                        </h3>
                        <img loading="lazy" class="carro" src="@if(!is_null($public) && $public) {{ asset('public/img/pic-carro-site.png') }} @else {{ asset('/img/pic-carro-site.png') }} @endif" alt="">        
                    </div>
                    <div class="col-lg-6">
                        <p class="mb-4">
                            O futuro começa AGORA. Nossa visão como empresa é a de viver em um mundo com mais qualidade de vida, onde a geração de  energia seja 100% limpa, sustentável e eficiente. E é para isso que a Speel Solar trabalha, em prol desta transformação.<br><br>
                            Quer conhecer um pouco mais a nossa história e como chegamos até aqui? Confira os próximos posts aqui nas redes sociais, nos quais contaremos com mais detalhes como tudo aconteceu.
                        </p>
                        <a href="/quem-somos" class="site-btn mt-4" title="Sobre nós"><img src="@if(!is_null($public) && $public) {{ asset('public/img/sol.svg') }} @else {{ asset('/img/sol.svg') }} @endif" alt="">Sobre nós</a>
                    </div>
                </div>
            </template>
        </home-boxes>
    </template>
    
    <!-- SOLAR -->
    <section class="solar-section">
        <div class="container">
            <div class="row bloco_solar d-flex">
                <h2 class="titulosolar">Solar</h2>
                <div class="col-lg-5">
                    <h2 class="subtitulo">Investir<br> no futuro</h2>
                </div>
                <div class="col-lg-7">
                    <img loading="lazy" class="placasolar" src="@if(!is_null($public) && $public) {{ asset('public/img/placasolar.png') }} @else {{ asset('/img/placasolar.png') }} @endif" alt="">
                </div>
                <div class="col-lg-5 pt-5 d-flex justify-content-end">
                    <h3 class="">Economia <br>e eficiência</h3>
                </div>
                <div class="col-lg-7 pt-5">
                    <p>Deixe o sol pagar a sua conta de energia!<br> Com a Speel Solar você pode economizar<br> até 95% através da capitação das placas solares,<br> enquanto valoriza em até 30% o seu imóvel.</p>
                </div>
            </div>
        </div>
    </section>

@endsection