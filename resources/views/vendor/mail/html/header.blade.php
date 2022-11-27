<tr>
<td class="header">
<a href="{{ BASEURL }}" style="display: inline-block;">
@if (trim($slot) === 'Coin Exporter')
<img src="{{ BASEURL }}images/coin-exporter.png" class="logo" alt="Coin Exporter" >
@else
{{ $slot }}
@endif
</a>
</td>
</tr>