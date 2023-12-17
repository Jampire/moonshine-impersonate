@if($canStop)
    <x-moonshine::link-button icon="{{ $icon }}" href="{{ $route }}" class="{{ $class }}">
        {{ $label }}
    </x-moonshine::link-button>
@endif
