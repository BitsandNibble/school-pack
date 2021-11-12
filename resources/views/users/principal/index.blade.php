<x-app-layout>
  Current Session : {{ \App\Helpers\SP::getSetting('current_session') }}

  <div class="row mt-5">
    <div class="col">
      <x-card radius="10" shadow="" class="overflow-hidden py-1">
        <div class="d-flex align-items-center">
          <div>
            <p class="mb-1 text-uppercase">Total Students</p>
            <h5 class="mb-0 display-6">{{ \App\Helpers\SP::totalStudents() }}</h5>
          </div>
          <div class="ms-auto"><i class="bx bx-user font-30"></i>
          </div>
        </div>
      </x-card>
    </div>

    <div class="col">
      <x-card radius="10" shadow="" class="overflow-hidden py-1">
        <div class="d-flex align-items-center">
          <div>
            <p class="mb-1 text-uppercase">Total Teachers</p>
            <h5 class="mb-0 display-6">{{ \App\Helpers\SP::totalTeachers() }}</h5>
          </div>
          <div class="ms-auto"><i class="bx bxs-user font-30"></i>
          </div>
        </div>
      </x-card>
    </div>
  </div>

  <livewire:components.show-notice />
</x-app-layout>