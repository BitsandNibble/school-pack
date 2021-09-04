<x-app-layout>
  <x-breadcrumb>
    <a href="{{ route('principal.results') }}">Results</a>
    <li class="breadcrumb-item active" aria-current="page">Result</li>
  </x-breadcrumb>

  <x-card>
    <div class="d-flex align-items-center">
      {{-- <h4 class="my-1">Class</h4> --}}

      <div class="ms-auto d-flex justify-content-end">
        <x-button>Print All Results</x-button>
      </div>
    </div>
  </x-card>

  <x-card>
    <div class="chip chip-lg">
      <img src="{{ asset('assets/_images/avatars/avatar-1.png') }}" alt="Contact Person">John Doe
    </div>
    <div class="chip chip-lg">
      <img src="{{ asset('assets/_images/avatars/avatar-1.png') }}" alt="Contact Person">John Doe
    </div>
    <div class="chip chip-lg">
      <img src="{{ asset('assets/_images/avatars/avatar-1.png') }}" alt="Contact Person">John Doe
    </div>
    <div class="chip chip-lg">
      <img src="{{ asset('assets/_images/avatars/avatar-1.png') }}" alt="Contact Person">John Doe
    </div>
    <div class="chip chip-lg">
      <img src="{{ asset('assets/_images/avatars/avatar-1.png') }}" alt="Contact Person">John Doe
    </div>
    <div class="chip chip-lg">
      <img src="{{ asset('assets/_images/avatars/avatar-1.png') }}" alt="Contact Person">John Doe
    </div>
    <div class="chip chip-lg">
      <img src="{{ asset('assets/_images/avatars/avatar-1.png') }}" alt="Contact Person">John Doe
    </div>
    <div class="chip chip-lg">
      <img src="{{ asset('assets/_images/avatars/avatar-1.png') }}" alt="Contact Person">John Doe
    </div>
    <div class="chip chip-lg">
      <img src="{{ asset('assets/_images/avatars/avatar-1.png') }}" alt="Contact Person">John Doe
    </div>
    <div class="chip chip-lg">
      <img src="{{ asset('assets/_images/avatars/avatar-1.png') }}" alt="Contact Person">John Doe
    </div>
    <div class="chip chip-lg">
      <img src="{{ asset('assets/_images/avatars/avatar-1.png') }}" alt="Contact Person">John Doe
    </div>
    <div class="chip chip-lg">
      <img src="{{ asset('assets/_images/avatars/avatar-1.png') }}" alt="Contact Person">John Doe
    </div>
  </x-card>

</x-app-layout>
