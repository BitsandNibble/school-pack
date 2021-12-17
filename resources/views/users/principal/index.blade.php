<x-app-layout>
  <p>Current Session : {{ get_setting('current_session') }}</p>
  <hr>

  <div class="row">
    <div class="col-md-6">
      <x-card radius="10" shadow="" class="overflow-hidden py-1">
        <div class="d-flex align-items-center">
          <div>
            <p class="mb-1 text-uppercase">Total Students</p>
            <h5 class="mb-0 display-6">{{ total_students() }}</h5>
          </div>
          <div class="ms-auto"><i class="bx bx-user font-30"></i>
          </div>
        </div>
      </x-card>
    </div>

    <div class="col-md-6">
      <x-card radius="10" shadow="" class="overflow-hidden py-1">
        <div class="d-flex align-items-center">
          <div>
            <p class="mb-1 text-uppercase">Total Teachers</p>
            <h5 class="mb-0 display-6">{{ total_teachers() }}</h5>
          </div>
          <div class="ms-auto"><i class="bx bxs-user font-30"></i>
          </div>
        </div>
      </x-card>
    </div>
  </div>

  <livewire:components.show-notice />
</x-app-layout>