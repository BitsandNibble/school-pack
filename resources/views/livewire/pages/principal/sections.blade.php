<div>
  <x-breadcrumb>
    Classes
    <li class="breadcrumb-item active" aria-current="page">Sections</li>
  </x-breadcrumb>
  <x-flash />

  <x-card>
    <div class="d-flex align-items-center">
      {{-- <h4 class="my-1">Class</h4> --}}

      <div class="ms-auto d-flex justify-content-end">
        <x-button data-bs-toggle="modal" data-bs-target="#sectionModal">Add New Section</x-button>
      </div>
    </div>
  </x-card>

  <x-card>
    <div class="d-flex align-items-center mb-3">
      <div class="d-flex justify-content-start">
        Show <span>&nbsp;</span>
        <select class="form-select form-select-sm" wire:model="paginate">
          <option value="10" selected>10</option>
          <option value="25">25</option>
          <option value="50">50</option>
          <option value="100">100</option>
        </select>
        <span>&nbsp;</span> entries
      </div>

      {{-- <div class="ms-auto d-flex justify-content-end">
        <x-input type="search" placeholder="Search" wire:model.deboounce.500ms="q" class="mb-3" />
      </div> --}}
    </div>

    <div class="table-responsive">
      <table class="table table-striped table-sm" style="width:100%">
        <thead>
          <tr>
            <th>S/N</th>
            <th>Class</th>
            <th wire:click="sortBy('name')" class="cursor-pointer">
              <div class="d-flex justify-content-between">
                Section
                <x-sort-icon sortField="name" :sortBy="$sortBy" :sortAsc="$sortAsc" />
              </div>
            </th>
            <th>Teacher</th>
            <th></th>
          </tr>
        </thead>

        <tbody>
          @forelse($sections as $section)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $section->class_room->name }}</td>
              <td>{{ $section->name }}</td>
              <td>{{ $section->teacher->fullname ?? '' }}</td>
              <td>
                <x-button class="px-0" wire:click="edit({{ $section->id }})" value="" data-bs-toggle="modal"
                          data-bs-target="#sectionModal">
                  <i class="bx bxs-pen"></i>
                </x-button>
                <x-button class="px-0" value="" wire:click="openDeleteModal({{ $section->id }})"
                          data-bs-toggle="modal" data-bs-target="#deleteModal">
                  <i class="bx bxs-trash-alt"></i>
                </x-button>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" align="center">No record found</td>
            </tr>
          @endforelse
        </tbody>
      </table>

      {{ $sections->links() }}
    </div>
  </x-card>


  <x-confirmation-modal id="sectionModal">
    <x-slot name="title">{{ isset($this->section_id) ? 'Edit' : 'Add New' }} Section</x-slot>

    <x-slot name="content">
      <p><span class="text-danger">*</span> fields are required</p>

      <div class="row">
        {{-- <x-validation-errors /> --}}

        <div class="col mb-2">
          <x-label for="name">Name <span class="text-danger">*</span></x-label>
          <x-input type="text" id="name" wire:model.defer="name" />
          <x-input-error for="name" />
        </div>

        <div class="col">
          <x-label for="class">Class <span class="text-danger">*</span></x-label>
          <x-select id="class" wire:model.defer="class">
            @foreach ($classes as $class)
              <option value="{{ $class->id }}">{{ $class->name }}</option>
            @endforeach
          </x-select>
          <x-input-error for="class" />
        </div>

        <div class="col">
          <x-label for="teacher_id">Class Teacher</x-label>
          @if (isset($this->class_id) && $this->teacher_id != '')
            <div class="d-flex justify-content">
              <h6 class="mr-4">{{ $existingTeacher }}</h6>
              <a class="text-dark" href="javascript:"
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
    </x-slot>

    <x-slot name="footer">
      <x-button value="dark" wire:click="cancel">Close</x-button>
      <x-button value="submit" wire:click.prevent="store">Save</x-button>
    </x-slot>
  </x-confirmation-modal>

  <x-confirmation-modal id="deleteModal">
    <x-slot name="title">Delete Section</x-slot>

    <x-slot name="content">
      Are you sure you want to delete this class section?
    </x-slot>

    <x-slot name="footer">
      <x-button value="dark" wire:click="cancel">Cancel</x-button>
      <x-button value="danger" wire:click.prevent="delete({{ $deleting }})">Delete</x-button>
    </x-slot>
  </x-confirmation-modal>

  <x-spinner />
</div>
