@props(['name', 'label', 'value' => '1', 'checked' => false, 'disabled' => false, 'id' => null])
@php
    $id = $id ?: 'rai-check-' . \Illuminate\Support\Str::uuid();
    $oldKey = str_ends_with($name, '[]') ? substr($name, 0, -2) : $name;
    $oldValue = old($oldKey);
    $isChecked = is_array($oldValue)
        ? in_array((string) $value, array_map('strval', $oldValue), true)
        : (is_null($oldValue) ? $checked : (string) $oldValue === (string) $value);
@endphp
<label class="rai-check" for="{{ $id }}">
    <input {{ $attributes->class(['rai-check__input'])->merge(['type'=>'checkbox','id'=>$id,'name'=>$name,'value'=>$value]) }} @checked($isChecked) @disabled($disabled)>
    <span class="rai-check__box" aria-hidden="true"></span>
    <span class="rai-check__label">{{ $label }}</span>
</label>
