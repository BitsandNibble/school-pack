<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-dark btn-round']) }}>
  {{ $slot }}
</button>