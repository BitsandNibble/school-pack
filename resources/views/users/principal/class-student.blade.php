<x-app-layout>
  <x-breadcrumb>
    <a href="{{ route('principal.classes') }}">Classes</a>
    <li class="breadcrumb-item active" aria-current="page">Students</li>
  </x-breadcrumb>

  <livewire:pages.principal.student :id="$class->id" :type="2" />
</x-app-layout>
