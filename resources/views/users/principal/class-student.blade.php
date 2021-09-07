<x-app-layout>
  <x-breadcrumb>
    <a href="{{ route('principal.classes') }}">Classes</a>
    <li class="breadcrumb-item active" aria-current="page">Students</li>
  </x-breadcrumb>
  <x-flash />

  <x-card>
    <div class="d-flex align-items-center">
      <h4 class="my-1">{{ $class->name }}</h4>

      {{-- <div class="ms-auto d-flex justify-content-end">
        <x-button data-bs-toggle="modal" data-bs-target="#classModal">Add New Class</x-button>
      </div> --}}
    </div>
  </x-card>

  <livewire:pages.principal.student :id="$class->id" :type="2" />
</x-app-layout>
