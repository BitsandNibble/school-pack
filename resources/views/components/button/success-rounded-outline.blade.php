<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-outline-success px-5 radius-30']) }}>
  {{ $slot }}
</button>