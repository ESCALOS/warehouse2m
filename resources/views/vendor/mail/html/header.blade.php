@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Agricola2m')
<img src="{{ env('LOGO_URL','https://i.ibb.co/yV51Drs/logo.png') }}" class="logo" alt="Agricola2m Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
