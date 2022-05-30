@component('mail::message')
<h1>Novo Contato Recebido</h1>
<p>
    Olá <b>{{$contact->name}}</b>! <br> <br>
    Estamos muito felizes com o seu contato!
    Agora é só aguardar um pouco, estaremos respondendo o mais preve possível. <br>
    Enquanto isso pode ficar tranquilo pra visitar 
    <a href="{{$site}}" target="_blank">nosso site e conhecer melhor nossas soluções</a> se ainda não o fez... <br>
    Grande Abraço!
</p>

<h2>{{$contact->subject}}</h2>
<p>"{{$contact->message}}"</p>

<small>
    Essa é uma mensagem de confirmação de envio único. <br>
    Se você você não solicitou o recebimento desse email, não se preocupe, não é spam. 
    Os dados pessoais compartilhados só serão usados para contato posterior para orçamentos e/ou projetos.
</small>

@if ($email_confirmation_image)
<img style="visibility: hidden; position: absolute;" src="{{$email_confirmation_image}}">
@endif
@endcomponent