@props(['value' => 'primary'])

<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-outline-'.$value]) }}>
  {{ $slot }}
</button>