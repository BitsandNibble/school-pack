<x-app-layout>
  <x-breadcrumb>Subjects</x-breadcrumb>

  <x-card>
    <div class="d-flex align-items-center">
      {{-- <h4 class="my-1">Class</h4> --}}

      <div class="ms-auto d-flex justify-content-end">
        <x-button data-bs-toggle="modal" data-bs-target="#subjectModal">Add New Subject</x-button>
      </div>
    </div>
  </x-card>

  <x-card>
    <div class="row pricing-table">
      @for ($i = 1; $i <= 10; $i++)
        <div class="col-md-4 col-sm-6">
          <x-card>
            <div class="d-flex align-items-center">
              <div>
                <h4>Mathematics</h4>
                <h6 class="mt-1">SSS1</h6>
                <p class="mt-1">Mrs Sanusi</p>
              </div>
              <div class="dropdown ms-auto d-flex justify-content-end">
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
    <x-modal id="subjectModal">
      <x-slot name="title">Add New Subject</x-slot>
      <x-slot name="content"></x-slot>
      <x-slot name="footer"></x-slot>
    </x-modal>
  @endpush
</x-app-layout>
