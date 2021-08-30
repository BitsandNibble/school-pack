<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-outline-primary px-5 radius-30']) }}>
  {{ $slot }}
</button>