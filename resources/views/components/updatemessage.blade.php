<div>
    @props(['message'])
    @if ($message)
    <div class="p-4 m-2 rounded bg-white">
        {{$message}}
    </div>
    @endif
</div>