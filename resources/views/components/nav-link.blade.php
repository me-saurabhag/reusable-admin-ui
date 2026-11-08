@props(['href' => '#', 'icon' => '•', 'active' => false])
<a href="{{ $href }}" {{ $attributes->class(['rai-ui__nav-link', 'is-active' => $active])->merge($active ? ['aria-current' => 'page'] : []) }}><span class="rai-ui__nav-icon" aria-hidden="true">{{ $icon }}</span><span>{{ $slot }}</span></a>
