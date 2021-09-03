<x-base-layout>
  <x-breadcrumb>Classes</x-breadcrumb>

  <x-card>
    <x-button data-bs-toggle="modal" data-bs-target="#classModal">Add New Class</x-button>
  </x-card>

  <x-card>
    <div class="row">
      @for ($i = 1; $i <= 10; $i++)
        <div class="col-md-4 col-sm-6">
          <x-card>
            <div class="d-flex align-items-center">
              <div>
                <p class="mb-0 text-dark">Class Teacher</p>
                <p class="mb-0 text-primary">Mr Something</p>
                <h5 class="mb-0">JSS1</h5>
              </div>
              <div class="dropdown ms-auto" style="position: relative;">
                <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown">
                  <i class='bx bx-dots-horizontal-rounded font-22'></i>
                </div>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="javascript:;">Edit</a></li>
                  <li><a class="dropdown-item" href="javascript:;">Delete</a></li>
                </ul>
              </div>
            </div>
          </x-card>
        </div>
      @endfor
    </div>
  </x-card>


  @push('modals')
    <x-modal id="classModal">
      <x-slot name="title">Add New Class</x-slot>
      <x-slot name="footer"></x-slot>
    </x-modal>
  @endpush
</x-base-layout>
