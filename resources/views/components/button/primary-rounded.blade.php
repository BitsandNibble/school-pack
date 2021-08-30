<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-primary px-5 radius-30']) }}>
  {{ $slot }}
</button>