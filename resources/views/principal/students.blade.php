<x-base-layout>
  <x-breadcrumb>Students</x-breadcrumb>

  <x-card>
    <div class="row pricing-table">
      @for ($i = 1; $i <= 10; $i++)
        <div class="col-md-4 col-sm-6">
          <x-card>
            <div class="d-flex align-items-center">
              <a href="{{ route('student') }}" class="stretched-link w-100" style="position: relative">
                <h4 class="my-1">JSS1</h4>
              </a>
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

</x-base-layout>
