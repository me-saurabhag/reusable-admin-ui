@props([
    'name',
    'label' => null,
    'id' => null,
    'value' => null,
    'rows' => 4,
    'size' => 'md',
    'required' => false,
    'help' => null,
    'error' => null,
    'appearance' => 'outline',
    'm' => null, 'mt' => null, 'mb' => null, 'ms' => null, 'me' => null, 'mx' => null, 'my' => null,
])

@php
    $id = $id ?: 'rai-textarea-' . \Illuminate\Support\Str::uuid();
    $validationError = $error ?? (isset($errors) ? ($errors->first($name) ?: null) : null);
    if (! in_array($size, ['sm', 'md', 'lg'], true)) {
        throw new \InvalidArgumentException('Textarea size must be sm, md, or lg.');
    }
    if (! in_array($appearance, ['outline', 'filled', 'underline'], true)) {
        throw new \InvalidArgumentException('Textarea appearance must be outline, filled, or underline.');
    }
    $descriptionId = $id . '-description';
    $hasDescription = filled($help) || filled($validationError);
    $spacingScale = ['0','1','2','3','4','5','6','8','10','12','16'];
    $spacingClasses = [];
    foreach (['m','mt','mb','ms','me','mx','my'] as $prop) {
        if ($$prop !== null && $$prop !== '') {
            $v = (string) $$prop;
            if (! in_array($v, $spacingScale, true) && !(in_array($prop, ['mx','ms','me'], true) && $v === 'auto')) {
                throw new \InvalidArgumentException("Invalid textarea spacing value for {$prop}.");
            }
            $spacingClasses[] = 'rai-' . $prop . '-' . $v;
        }
    }
@endphp

<div {{ $attributes->only([])->class(array_merge(['rai-field'], $spacingClasses)) }}>
    @if ($label)
        <label class="rai-field__label" for="{{ $id }}">
            {{ $label }} @if ($required)<span class="rai-field__required" aria-hidden="true">*</span>@endif
        </label>
    @endif
    <textarea
        {{ $attributes->class(['rai-control','rai-control--textarea','rai-control--' . $size,'rai-control--' . $appearance,'is-invalid' => filled($validationError)])->merge([
            'id' => $id, 'name' => $name, 'rows' => $rows,
            'aria-describedby' => $hasDescription ? $descriptionId : null,
            'aria-invalid' => filled($validationError) ? 'true' : 'false',
        ]) }}
        @required($required)
    >{{ old($name, $value) }}</textarea>
    @if ($hasDescription)
        <div id="{{ $descriptionId }}" class="rai-field__description">
            @if ($help)<span class="rai-field__help">{{ $help }}</span>@endif
            @if ($validationError)<span class="rai-field__error" role="alert">{{ $validationError }}</span>@endif
        </div>
    @endif
</div>
