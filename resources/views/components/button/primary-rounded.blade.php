<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-primary btn-round']) }}>
  {{ $slot }}
</button>