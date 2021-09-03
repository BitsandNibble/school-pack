<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-outline-submit']) }}>
  {{ $slot }}
</button>