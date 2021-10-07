@props(['value' => 'primary'])

<a {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-sm btn-'.$value]) }}>
  {{ $slot }}
</a>