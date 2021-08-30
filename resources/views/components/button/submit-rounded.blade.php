<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-submit px-5 radius-30']) }}>
  {{ $slot }}
</button>