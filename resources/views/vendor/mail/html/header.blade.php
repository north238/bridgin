@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'bridgin')
<img src="{{ asset('/images/bridgin_v2/bridgin_v2_fill_none.svg') }}" class="logo" alt="bridgin">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
