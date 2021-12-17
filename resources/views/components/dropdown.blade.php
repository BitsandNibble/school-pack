@props(['value' => 'secondary'])

<div class="dropdown">
  <button {{ $attributes->merge(['class' => 'btn btn-sm dropdown-toggle btn-' . $value]) }} type="button"
    id="dropdownMenu" data-bs-toggle="dropdown" aria-expanded="false">
    {{ $title }}
  </button>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenu">
    {{ $slot }}
    {{-- <li><a class="dropdown-item" href="#">Action</a></li> --}}
  </ul>
</div>
