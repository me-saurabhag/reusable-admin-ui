@props(['name', 'label', 'value', 'checked' => false, 'disabled' => false, 'id' => null])
@php $id = $id ?: 'rai-radio-' . \Illuminate\Support\Str::uuid(); @endphp
<label class="rai-radio" for="{{ $id }}">
    <input {{ $attributes->class(['rai-radio__input'])->merge(['type'=>'radio','id'=>$id,'name'=>$name,'value'=>$value]) }} @checked(old($name, $checked) == $value) @disabled($disabled)>
    <span class="rai-radio__circle" aria-hidden="true"></span>
    <span class="rai-radio__label">{{ $label }}</span>
</label>
