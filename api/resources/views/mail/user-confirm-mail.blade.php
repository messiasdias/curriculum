@component('mail::message')
<h1>Confimar Endereço de Email</h1>
<p>
    Olá <b>{{$user->name}}</b>! <br><br>
    Essa é uma mensagem de confirmação enviada a partir da criação do usúario no sistema ou atualização do endereço de email.  <br>
    <a href="{{$link}}" target="_blank">Clique aqui para Confirmar o seu Email</a> e ser redirecionado para o site.<br>
</p>
@component('mail::button', ['url' => $link])
    Confirmar Email
@endcomponent

@endcomponent