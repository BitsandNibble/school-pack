<div {{ $attributes->merge(['class' => 'card radius-15 w-100 shadow-lg']) }}>
  <div class="card-body">
    {{ $slot }}
  </div>
</div>