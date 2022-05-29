@props(['value' => 'primary'])

<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-sm btn-'.$value]) }}>
    {{ $slot }}
</button>