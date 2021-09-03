@props(['value' => 'primary'])

<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-round btn-outline-'.$value]) }}>
  {{ $slot }}
</button>