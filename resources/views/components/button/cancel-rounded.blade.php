<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-dark px-5 radius-30']) }}>
  {{ $slot }}
</button>