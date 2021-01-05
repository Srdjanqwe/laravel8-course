<p class="text-muted">
    {{ empty(trim($slot)) ? 'Added ' : $slot }} {{ $date }}
    @if(isset($name))
        by {{ $name }}
    @endif
</p>
