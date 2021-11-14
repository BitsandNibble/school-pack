<x-app-layout>
  Current Session : {{ \App\Helpers\SP::getSetting('current_session') }}
  <hr>
  <div class="row">
    @forelse($sections as $section)
      <div class="col-4">
        <x-card>
          <div class="text-center">
            <div class="widgets-icons rounded-circle mx-auto bg-light-success text-success mb-3"><i
                  class="bx bxs-graduation"></i>
            </div>
            <h4 class="my-1">{{ $section->class_room->name . ' ' . $section->name }}</h4>
            <p class="mb-0 text-secondary">Class teacher for this session</p>
          </div>
        </x-card>
      </div>
    @empty
      <div class="col-4">
        <x-card>
          <div class="text-center">
            <div class="widgets-icons rounded-circle mx-auto bg-light-success text-success mb-3"><i
                  class="bx bxs-graduation"></i>
            </div>
            <h4 class="my-1">None for this term</h4>
            <p class="mb-0 text-secondary">Class teacher for this session</p>
          </div>
        </x-card>
      </div>
    @endforelse
  </div>

  <livewire:components.show-notice />
</x-app-layout>