<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
            @if (trim($slot) === 'Laravel')
                <img src="{{ config('app.url', '') }}/img/home/main-logo.png" class="logo" alt="{{ config('app.name', '') }}">
            @else
                <img src="{{ config('app.url', '') }}i/img/home/main-logo.png" class="logo" style="width: 130px !important;height: 40px!important;" alt="{{ config('app.name', '') }}">
            @endif
        </a>
    </td>
</tr>
