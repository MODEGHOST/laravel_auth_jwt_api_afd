@props(['url'])
<tr>
<td class="header">
<a href="https://react-ot-online-system.vercel.app/" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="" class="logo" alt="Laravel Logo">
<!-- <img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo"> -->
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
