<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-outline-danger px-5 radius-30']) }}>
  {{ $slot }}
</button>
