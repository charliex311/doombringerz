{{-- Alert --}}
    @foreach (['warning', 'success', 'info', 'danger'] as $type)
        @if(Session::has('alert.' . $type))
            @foreach(Session::get('alert.' . $type) as $message)
                <div class="alert alert-fill alert-{{ $type }} alert-dismissible alert-icon">
                    <span>{{ $message }}</span>
                </div>
            @endforeach
        @endif
    @endforeach
{{-- End Alert --}}