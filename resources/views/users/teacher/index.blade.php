<x-app-layout>
  <hr>
  @forelse(auth()->user()->classes as $class)
    <div class="row">
      <div class="col-4">
        <x-card>
          <div class="text-center">
            <div class="widgets-icons rounded-circle mx-auto bg-light-success text-success mb-3"><i
                  class="bx bxs-graduation"></i>
            </div>
            <h4 class="my-1">{{ $class->name }}</h4>
            <p class="mb-0 text-secondary">Class teacher for this session</p>
          </div>
        </x-card>
      </div>
    </div>
  @empty
    <div class="row">
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
    </div>
  @endforelse
</x-app-layout>