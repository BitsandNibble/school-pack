<div>
  <x-breadcrumb>Classes</x-breadcrumb>
  <x-flash />

  <x-card>
    <div class="d-flex align-items-center">
      {{-- <h4 class="my-1">Class</h4> --}}

      <div class="ms-auto d-flex justify-content-end">
        <x-button data-bs-toggle="modal" data-bs-target="#classModal">Add New Class</x-button>
      </div>
    </div>
  </x-card>

  <x-card>
    <div class="d-flex align-items-center mb-2">
      <div class="d-flex justify-content-start">
        Show <span>&nbsp;</span>
        <select class="form-select form-select-sm" wire:model="paginate">
          <option value="6" selected>6</option>
          <option value="10">10</option>
          <option value="20">20</option>
          <option value="25">25</option>
        </select>
        <span>&nbsp;</span> entries
      </div>
    </div>
    <div class="row pricing-table">
      @foreach ($classes as $class)
        <div class="col-md-4 col-sm-6">
          <x-card>
            <div class="d-flex align-items-center">
              <a href="{{ route('principal.classes.students', [$class]) }}">
                <h6 class="mb-1 text-dark">Class Teacher</h6>
                <p class="mb-1 text-primary">
                  @forelse ($class->teachers as $teacher)
                    {{ $teacher->title }} {{ $teacher->fullname }}
                  @empty
                    ------
                  @endforelse
                </p>
                <h4 class="text-uppercase">{{ $class->name }}</h4>
              </a>
              <div class="dropdown ms-auto" style="position: relative;">
                <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown">
                  <i class='bx bx-dots-horizontal-rounded font-22'></i>
                </div>
                <ul class="dropdown-menu">
                  <li>
                    <a class="dropdown-item" href="javascript:;" wire:click="edit({{ $class->id }})"
                      data-bs-toggle="modal" data-bs-target="#classModal">
                      <i class="bx bxs-pen"></i> Edit
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="javascript:;" wire:click="openDeleteModal({{ $class->id }})"
                      data-bs-toggle="modal" data-bs-target="#deleteModal">
                      <i class="bx bxs-trash-alt"></i> Delete
                    </a>
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

  <x-card>
    <h5>Useful Tips <i class="bx bx-bulb font-24"></i></h5>

    <ol>
      <li class="text-justify">How to assign a teacher to a new class.
        <ol style="list-style-type: upper-roman;">
          <li class="mb-1">Click on the <kbd><i class='bx bx-dots-horizontal-rounded font-22'></i></kbd> icon
          </li>
          <li class="mb-1">Click on <kbd><i class="bx bxs-pen"></i> Edit</li></kbd>
          <li class="mb-1">If teacher already exists, click on the <kbd><i class="bx bxs-trash-alt"></i></kbd>
            icon to remove the teacher</li>
          <li class="mb-0">Now <code>Add</code> or <code>Edit</code> the teacher.</li>
        </ol>
      </li>
    </ol>
  </x-card>

  <x-modal id="classModal">
    <x-slot name="title">{{ isset($this->class_id) ? 'Edit' : 'Add New' }} Class</x-slot>

    <x-slot name="content">
      <form>
        <p><span class="text-danger">*</span> fields are required</p>

        <div class="row">
          {{-- <x-validation-errors /> --}}

          <div class="col-md-4 mb-2">
            <x-input type="hidden" wire:model="class_id" />
            <x-label for="name">Class name <span class="text-danger">*</span></x-label>
            <x-input type="text" id="name" wire:model.defer="name" />
            <x-input-error for="name" />
          </div>

          <div class="col-md-6 col">
            <x-label for="teacher_id">Class Teacher</x-label>
            @if (isset($this->class_id) && $this->teacher_id != '')
              <div class="d-flex justify-content">
                <h6 class="mr-4">{{ $existingTeacher }}</h6>
                <a class="text-dark" href="javascript:;"
                  wire:click.prevent="deleteExistingTeacher({{ $this->teacher_id }})">
                  <i class="bx bxs-trash-alt"></i>
                </a>
              </div>
            @else
              <x-select id="teacher_id" wire:model.defer="teacher_id">
                @foreach ($teachers as $teacher)
                  <option value="{{ $teacher->id }}">{{ $teacher->fullname }}</option>
                @endforeach
              </x-select>
            @endif
          </div>
        </div>
      </form>
    </x-slot>

    <x-slot name="footer">
      <x-button value="dark" wire:click="cancel">Close</x-button>
      <x-button value="submit" wire:click.prevent="store">Save</x-button>
    </x-slot>
  </x-modal>

  <x-confirmation-modal id="deleteModal">
    <x-slot name="title">Delete Class</x-slot>

    <x-slot name="content">
      Are you sure you want to delete this class?
    </x-slot>

    <x-slot name="footer">
      <x-button value="dark" wire:click="cancel">Cancel</x-button>
      <x-button value="danger" wire:click.prevent="delete({{ $deleting }})">Delete</x-button>
    </x-slot>
  </x-confirmation-modal>

  <x-spinner />
</div>
