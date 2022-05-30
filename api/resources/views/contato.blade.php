@extends('template.layout')

@section('content')
   
<div class="contact-section">
    <div class="container">
        <div class="row">

            <!-- contact info -->
            <div class="col-lg-4 contact-info">
                <div class="section-title left">
                    <h2>Seja você o <br>próximo a <br>economizar!</h2>
                </div>
                <p class="mb-4">
                    Rua Georgino Pioli Ribeiro, 369 <br>
                    CEP 81830060<br>
                    Curitiba, PR
                </p>
                <a href="https://api.whatsapp.com/send?phone=5545999145524" title="Clique para falar com nossa equipe" target="_blank" class="whats mb-2"><span class="fa fa-whatsapp mr-2"></span> 45 99914 5524</a>
            </div>

            <!-- contact form -->
            <div class="col-lg-8">
                <form class="form-class" action="">
                   <contact />
                </form>
            </div>
        </div>
    </div>
</div>

@endsection