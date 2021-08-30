<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-success btn-round']) }}>
  {{ $slot }}
</button>