<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-outline-primary btn-round']) }}>
  {{ $slot }}
</button>