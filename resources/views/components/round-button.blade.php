@props(['value' => 'primary'])

<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-round btn-'.$value]) }}>
  {{ $slot }}
</button>