@props(['as' => 'td', 'scope' => null, 'align' => null, 'width' => null])
@php
    if (! in_array($as, ['td', 'th'], true)) throw new \InvalidArgumentException('Table cell tag must be td or th.');
    $classes = ['rai-table__cell'];
    if (filled($align)) $classes[] = 'rai-table__cell--' . $align;
    $style = filled($width) ? 'width: ' . $width : null;
@endphp
<{{ $as }} @if(filled($scope)) scope="{{ $scope }}" @endif {{ $attributes->class($classes)->merge(['style' => $style]) }}>{{ $slot }}</{{ $as }}>
