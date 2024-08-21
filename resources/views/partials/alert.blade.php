<div class="alert alert-{{ $type }} alert-dismissible fade show" role="alert">
    @if (is_array($message))
        <ul class="mb-0">
            @foreach ($message as $msg)
                <li>{{ $msg }}</li>
            @endforeach
        </ul>
    @else
        {{ $message }}
    @endif
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
