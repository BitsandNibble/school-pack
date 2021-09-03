<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-outline-dark']) }}>
  {{ $slot }}
</button>