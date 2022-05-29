@props(['value' => 'primary'])

<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-sm btn-outline-'.$value]) }}>
    {{ $slot }}
</button>