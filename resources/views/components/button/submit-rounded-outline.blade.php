<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-outline-submit btn-round']) }}>
  {{ $slot }}
</button>