<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-outline-success']) }}>
  {{ $slot }}
</button>