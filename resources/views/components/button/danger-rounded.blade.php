<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-danger btn-round']) }}>
  {{ $slot }}
</button>