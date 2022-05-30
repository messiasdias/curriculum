@component('mail::message')
<h1>Novo Contato</h1>
<p>Nova mensagem recebida na caixa de entrada a partir do site.</p>

<p>
    <small>Nome: {{$contact->name}}</small> <br>
    <small>Telefone: {{$contact->phone}} </small> <br>
    <small>Email: {{$contact->email}} </small> <br>
    <small>Cidade/Estado: {{$contact->city}} - {{$contact->state}} </small> <br>
</p>

<h2>{{$contact->subject}}</h2>
<p>"{{$contact->message}}"</p>
@endcomponent