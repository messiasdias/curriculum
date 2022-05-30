<!doctype html>
<html lang="pt-br">
    @php $public_path = !is_null($public) && $public ? 'public/' : '' @endphp
    @include('includes.head', ['public_path' => $public_path])
    <body>
        <style type="text/css" media="screen">
            .teaser {
                width: 100%;
                padding-top: 170px;
                min-height: 100vh;
                background: url("@if(!is_null($public) && $public) {{ asset('public/img/bg-teaser.jpg') }}@else {{ asset('img/bg-teaser.jpg') }} @endif") center top no-repeat;
                background-size:cover;
                overflow: hidden;
            }
            .logoteaser {
                width: 430px;
                z-index: 10;
            }
            .carro {
                position: absolute;
                left: 0;
                z-index: 10;
                transform: translate(-50%, 40px)
            }

            .simule {

            }
            .simule h2 {
                z-index: 10;
                color: #fff;
                line-height: 1;
                font-size: 60px;
                padding:100px 0 30px;
            }
            .simule h2 span {
                font-family: 'Fibra Alt Light', sans-serif;
            }
            .simule .site-btn:hover {
                background-color: #fff;
                color: #008291
            }
            .simule .site-btn {
                z-index: 10;
                position: relative;
            }
            .simule h3 {
                position: absolute;
                bottom: -120px;
                left: 0;
                z-index: 1;
                font-size: 220px;
                -webkit-text-stroke: 1px #0995a5;
                line-height: 1;
                -webkit-text-fill-color: transparent;
            }
            .faturas {
                position: absolute;
                right: 0;
                z-index: 10;
                transform: translate(405px, -360px);
            }
            .footer {
                padding-top:100px;
                z-index: 10;
                position: relative;
                padding-bottom: 100px;
            }
            .footer p {
                color: #fff;
                font-size: 18px;
            }
            .footer .whats {
                display:flex;
                font-size: 22px;
                font-family: 'Fibra Alt Bold', sans-serif;
                color: #fff;
            }
            .footer .whats:hover {
                color: #fddc36;
            }
            .footer .whats span {
                color: #fddc49; 
            }
            .footer .medias {  }
            .footer .medias a {
                width: 60px;
                height: 60px;
                display: flex;
                align-items: center;
                justify-content: center;
                background-color: #fddc49;
                border-radius: 100%

            }
            .footer .medias a span.fa-facebook-official {
               color: #008291;
               font-size: 30px;
            }
            .footer .medias a span.fa-instagram {
                color: #008291;
                font-size: 32px;
            }
            .footer .medias a:hover {
                background-color: #fff;
            }

            /*RESPONSIVE SHEET*/
            @media (max-width: 991px) {
                .teaser {
                    padding-top: 35px;
                }
               .carro {
                display: none;
               }
               .simule h3{
                bottom: 170px;
               }
               .simule .w-100 {
                justify-content: start!important;
               }
               .faturas {
                    transform: translate(100px, -385px);
                }

            }
            @media (max-width: 770px) {
                .faturas {
                    display: none;
                }
                .simule h2 {
                    padding-top: 60px;
                }
                .simule h3 {
                    font-size: 160px;
                }
                .footer {
                    padding: 50px 0 30px;
                }
            }

            @media (max-width: 400px) {
                .logoteaser{
                    width: 100%;
                }
            }
        </style>
        
        <div class="teaser">            
            <div class="container">
                <div class="row">
                    <div class="col-12 d-flex justify-content-center">
                        <a href="/home"><img class="logoteaser" src="@if(!is_null($public) && $public){{ asset('public/img/speel2.svg') }}@else{{ asset('img/speel2.svg') }}@endif" alt=""></a>
                        <img loading="lazy" class="carro" src="@if(!is_null($public) && $public){{ asset('public/img/pic-carro.png') }}@else{{ asset('img/pic-carro.png') }} @endif" alt="">
                    </div>
                    <div class="col-lg-8 col-12 simule">
                        <div class="w-100 d-flex justify-content-end">
                            <h2>Simule<br> grátis <span>sua</span><br> economia</h2>
                        </div>
                        <div class="w-100  d-flex justify-content-end">
                            <a target="_blank" href="https://www.faturapositiva.com.br/auth/registration" class="site-btn" title="Simule sua econômia">
                                <img src="@if(!is_null($public) && $public){{ asset('public/img/calculator2.svg') }}@else{{ asset('img/calculator2.svg') }}@endif" alt="">
                                Simule sua econômia
                            </a>
                        </div>
                        <img class="faturas" src="@if(!is_null($public) && $public){{ asset('public/img/faturas.png') }}@else{{ asset('img/faturas.png') }}@endif" alt="">
                        <h3>Em breve</h3>
                    </div>
                </div>
                <div class="row footer">
                    <div class="col-lg-4 mb-4 col-12">
                        <p>Rua Georgino Pioli Ribeiro, 369 CEP 81830060 - Curitiba, PR</p>
                        <a href="https://api.whatsapp.com/send?phone=5545999145524" title="Clique para falar com nossa equipe" target="_blank" class="whats mb-2"><span class="fa fa-whatsapp mr-2"></span> 45 99914 5524</a>
                        <!-- <a href="" class="whats"><span class="fa fa-whatsapp mr-2"></span>45 99914 5524</a> -->
                    </div>
                    <div class="col-lg-4 col-12 medias d-flex">
                        <a title="Acesse o Facebook da Speel Solar" target="_blank" href="https://www.facebook.com/speelsolar"><span class="fa fa-facebook-official"></span></a>
                        <a class="ml-2" title="Acesse o Instagram da Speel Solar" target="_blank" href="https://www.instagram.com/speelenergiasolar/"><span class="fa fa-instagram"></span></a>
                    </div>
                </div>
            </div>
        </div>

        
    </body>
</html>