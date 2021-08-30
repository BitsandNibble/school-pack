<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-outline-dark px-5 radius-30']) }}>
  {{ $slot }}
</button>