@props([
    'href' => null,
    'danger' => false,
    'disabled' => false,
    'divider' => false,
])

@if ($divider)
    <div {{ $attributes->class(['rai-dropdown__divider']) }} role="separator"></div>
@elseif ($href)
    <a href="{{ $href }}" {{ $attributes->class(['rai-dropdown__item', 'rai-dropdown__item--danger' => $danger, 'is-disabled' => $disabled]) }} role="menuitem" @if($disabled) aria-disabled="true" tabindex="-1" @endif>
        @if (isset($icon))<span class="rai-dropdown__item-icon" aria-hidden="true">{{ $icon }}</span>@endif
        <span>{{ $slot }}</span>
    </a>
@else
    <button type="button" {{ $attributes->class(['rai-dropdown__item', 'rai-dropdown__item--danger' => $danger]) }} role="menuitem" @disabled($disabled)>
        @if (isset($icon))<span class="rai-dropdown__item-icon" aria-hidden="true">{{ $icon }}</span>@endif
        <span>{{ $slot }}</span>
    </button>
@endif
