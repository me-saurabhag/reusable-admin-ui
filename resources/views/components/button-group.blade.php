@props(['attached' => true])
<div {{ $attributes->class(['rai-btn-group', 'rai-btn-group--attached' => $attached]) }} role="group">
    {{ $slot }}
</div>
