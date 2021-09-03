<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-outline-success btn-round']) }}>
  {{ $slot }}
</button>