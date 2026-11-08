@props(['gap' => '1.25rem'])
<div {{ $attributes->class(['rai-row'])->style('--rai-row-gap: ' . $gap) }}>{{ $slot }}</div>
