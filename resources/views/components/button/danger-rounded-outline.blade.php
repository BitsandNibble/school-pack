<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-outline-danger btn-round']) }}>
  {{ $slot }}
</button>
