<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-submit']) }}>
  {{ $slot }}
</button>