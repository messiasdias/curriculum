<!-- FATURAS -->
<section class="faturas_section">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 economia">
                <h2 class="mb-4">Simule grátis sua econômia</h2>
                <a target="_blank" href="https://www.faturapositiva.com.br/auth/registration" class="site-btn" title="Simule sua econômia">
                    <img src="@if(!is_null($public) && $public) {{ asset('public/img/calculator2.svg') }} @else {{ asset('/img/calculator2.svg') }} @endif" alt="">
                    Simule sua econômia
                </a>
                <img class="pic-faturas" src="@if(!is_null($public) && $public) {{ asset('public/img/pic-faturas.png') }} @else {{ asset('/img/pic-faturas.png') }} @endif" alt="">
            </div>
            <div class="col-lg-7">
                <h3>Fatura<br> Positiva</h3>
                <div class="d-flex justify-content-end">
                    <p>
                        Entre e confira nossa <br>
                        plataforma GRÁTIS, iremos <br>
                        escomplicar seu projeto! 
                    </p>   
                </div>
                 
            </div>
        </div>
    </div>
</section>
<footer class="footer-section">
	<div class="container">
		<div class="row">
			<div class="col-lg-2 col-12">
				<a href="" class="d-inline" title="">
					<img class="logo" src="@if(!is_null($public) && $public) {{ asset('public/img/marca_compacta.svg') }} @else {{ asset('/img/marca_compacta.svg') }} @endif" alt="">
				</a>
			</div>
			<div class="col-lg-2 col-md-4">
				<ul class="menurodape">
                    <li class=""><a href="{{ url('/home') }}">Início</a></li>
					<li class=""><a href="{{ url('/quem-somos') }}">Quem somos</a></li>
					<li class=""><a href="{{ url('/solucoes') }}">Soluções</a></li>
					<li class=""><a href="{{ url('/cases') }}">Cases</a></li>
					<li class=""><a href="{{ url('/contato') }}">Contato</a></li>
				</ul>
			</div>
			<div class="col-lg-4 col-md-4 medias d-flex justify-content-center">
				<a title="Acesse o Facebook da Speel Solar" target="_blank" href="https://www.facebook.com/speelsolar"><span class="fa fa-facebook-official"></span></a>
                <a class="ml-2" title="Acesse o Instagram da Speel Solar" target="_blank" href="https://www.instagram.com/speelenergiasolar/"><span class="fa fa-instagram"></span></a>
			</div>
			<div class="col-lg-4 col-md-4">
				<p>Rua Georgino Pioli Ribeiro, 369 CEP 81830060 - Curitiba, PR</p>
                 <a href="https://api.whatsapp.com/send?phone=5545999145524" title="Clique para falar com nossa equipe" target="_blank" class="whats mb-2"><span class="fa fa-whatsapp mr-2"></span> 45 99914 5524</a>
			</div>
		</div>
	</div>
</footer>