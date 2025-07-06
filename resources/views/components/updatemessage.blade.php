<div>
    @props(['message'])
    @if ($message)
    <div class="p-4 m-2 rounded bg-blue-300">
        {{$message}}
    </div>
    @endif
</div>