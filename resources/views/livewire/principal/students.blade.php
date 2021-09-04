<div>
  <x-breadcrumb>Students</x-breadcrumb>

  <x-card>
    <div class="row pricing-table">
      @foreach ($classes as $class)
        <div class="col-md-4 col-sm-6">
          <x-card>
            <div class="d-flex align-items-center">
              <a href="{{ route('principal.student') }}" class="stretched-link w-100">
                <h4 class="my-1">{{ $class->name }}</h4>
              </a>
              <div class="ms-auto d-flex justify-content-end">
                <div class="cursor-pointer">
                  <i class='bx bxs-right-arrow-circle font-22'></i>
                </div>
              </div>
            </div>
          </x-card>
        </div>
      @endforeach
    </div>
  </x-card>

  <x-card>
    <h5>All Students</h5>
    {{ $students }}
  </x-card>
</div>
