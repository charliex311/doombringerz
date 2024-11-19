<li class="nk-menu-heading">
    <h6 class="overline-title text-primary-alt">{{ __('Выбор сервера') }}</h6>
</li>

<li class="nk-menu-item">
    <select id="select-server" name="select-server" class="form-select">
        @foreach(getservers() as $server)
            <option value="{{ $server->id }}" @if ($server->id == session('server_id')) selected @endif>{{ $server->name }}</option>
        @endforeach
    </select>
</li>
