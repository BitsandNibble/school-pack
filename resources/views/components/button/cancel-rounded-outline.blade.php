<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-outline-dark btn-round']) }}>
  {{ $slot }}
</button>