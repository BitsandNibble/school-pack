@props(['value' => 'primary'])

<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-'.$value]) }}>
  {{ $slot }}
</button>