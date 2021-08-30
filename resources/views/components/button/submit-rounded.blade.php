<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-submit btn-round']) }}>
  {{ $slot }}
</button>