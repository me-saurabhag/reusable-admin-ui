@props(['name', 'label', 'checked' => false, 'disabled' => false, 'id' => null])
@php $id = $id ?: 'rai-switch-' . \Illuminate\Support\Str::uuid(); @endphp
<label class="rai-switch" for="{{ $id }}">
    <input {{ $attributes->class(['rai-switch__input'])->merge(['type'=>'checkbox','role'=>'switch','id'=>$id,'name'=>$name,'value'=>'1']) }} @checked(old($name, $checked)) @disabled($disabled)>
    <span class="rai-switch__track" aria-hidden="true"><span class="rai-switch__thumb"></span></span>
    <span class="rai-switch__label">{{ $label }}</span>
</label>
