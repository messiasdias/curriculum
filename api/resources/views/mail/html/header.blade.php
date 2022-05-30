<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Speel Solar')
<img src="{{ asset('/img/speel.svg')}}" class="logo" alt="Speel Solar Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
