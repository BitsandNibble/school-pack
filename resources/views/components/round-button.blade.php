@props(['value' => 'primary'])

<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-sm btn-round btn-'.$value]) }}>
  {{ $slot }}
</button>