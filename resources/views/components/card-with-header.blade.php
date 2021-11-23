@props(['radius' => '15', 'shadow' => '-lg'])

<div {{ $attributes->merge(['class' => 'card radius-' . $radius .' w-100 shadow' . $shadow]) }}>
  <div class="card-header">
    {{ $header }}
  </div>

  <div class="card-body">
    {{ $slot }}
  </div>
</div>