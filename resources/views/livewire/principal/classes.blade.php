<div>
  <x-flash />

  <x-card>
    <x-button data-bs-toggle="modal" data-bs-target="#classModal">Add New Class</x-button>
  </x-card>

  <x-card>
    <div class="row pricing-table">
      @foreach ($classes as $class)
        <div class="col-md-4 col-sm-6">
          <x-card>
            <div class="d-flex align-items-center">
              <div>
                <h6 class="mb-1 text-dark">Class Teacher</h6>
                <p class="mb-1 text-primary">
                  @forelse ($class->teachers as $teacher)
                    {{ $teacher->title }} {{ $teacher->fullname }}
                  @empty
                    ------
                  @endforelse
                </p>
                <h4 class="text-uppercase">{{ $class->name }}</h4>
              </div>
              <div class="dropdown ms-auto" style="position: relative;">
                <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown">
                  <i class='bx bx-dots-horizontal-rounded font-22'></i>
                </div>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="javascript:;">Edit</a></li>
                  <li>
                    <a class="dropdown-item" href="javascript:;" wire:click.prevent="delete({{ $class->id }})"
                      onclick="confirm('Are you sure you want to delete this class?') || event.stopImmediatePropagation()"><i
                        class="bx bx-trash-alt"></i> Delete</a>
                  </li>
                </ul>
              </div>
            </div>
          </x-card>
        </div>
      @endforeach
    </div>
    {{ $classes->links() }}
  </x-card>

  <x-modal id="classModal">
    <x-slot name="title">Add New Class</x-slot>

    <x-slot name="content">
      <form>
        <p><span class="text-danger">*</span> fields are required</p>

        <div class="row">
          {{-- <x-validation-errors /> --}}

          <div class="col-md-4">
            <x-label for="name">Class name <span class="text-danger">*</span></x-label>
            <x-input type="text" id="name" wire:model.defer="class.name" />
            <x-input-error for="class.name" />
          </div>

          <div class="col-md-4">
            <x-label for="teacher_id">Class Teacher</x-label>
            <x-select id="teacher_id" wire:model.defer="class.teacher_id">
              @foreach ($teachers as $teacher)
                <option value="{{ $teacher->id }}">{{ $teacher->fullname }}</option>
              @endforeach
            </x-select>
          </div>
        </div>
      </form>
    </x-slot>

    <x-slot name="footer">
      <x-button value="dark" wire:click="close">Close</x-button>
      <x-button value="submit" wire:click.prevent="store">Save</x-button>
    </x-slot>
  </x-modal>
</div>
