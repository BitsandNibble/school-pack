<div>
  <x-breadcrumb>
    Classes
    <li class="breadcrumb-item active" aria-current="page">Classes</li>
  </x-breadcrumb>
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
            <th wire:click="sortBy('name')" class="cursor-pointer">
              <div class="d-flex justify-content-between">
                Name
                <x-sort-icon sortField="name" :sortBy="$sortBy" :sortAsc="$sortAsc" />
              </div>
            </th>
            <th wire:click="sortBy('class_type_id')" class="cursor-pointer">
              <div class="d-flex justify-content-between">
                Class Type
                <x-sort-icon sortField="class_type_id" :sortBy="$sortBy" :sortAsc="$sortAsc" />
              </div>
            </th>
            <th></th>
          </tr>
        </thead>

        <tbody>
          @forelse($classes as $class)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td style="transform: rotate(0);">
                <a href="{{ route('principal.classes.students', [$class->slug]) }}"
                   class="stretched-link">
                  {{ $class->name }}
                </a>
              </td>
              <td>{{ $class->class_type->name ?? '' }}</td>
              <td>
                <x-button class="px-0" wire:click="edit({{ $class->id }})" value="" data-bs-toggle="modal"
                          data-bs-target="#classModal">
                  <i class="bx bxs-pen"></i>
                </x-button>
                <x-button class="px-0" value="" wire:click="openDeleteModal({{ $class->id }})"
                          data-bs-toggle="modal" data-bs-target="#deleteModal">
                  <i class="bx bxs-trash-alt"></i>
                </x-button>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="4" align="center">No record found</td>
            </tr>
          @endforelse
        </tbody>
      </table>

      {{ $classes->links() }}
    </div>
  </x-card>

  <x-confirmation-modal id="classModal">
    <x-slot name="title">{{ isset($this->class_id) ? 'Edit' : 'Add New' }} Class</x-slot>

    <x-slot name="content">
      <p><span class="text-danger">*</span> fields are required</p>

      <div class="row">
        {{-- <x-validation-errors /> --}}

        <div class="col mb-2">
          <x-label for="name">Class Name <span class="text-danger">*</span></x-label>
          <x-input type="text" id="name" wire:model.defer="name" />
          <x-input-error for="name" />
        </div>

        <div class="col mb-2">
          <x-label for="class_type">Class Type <span class="text-danger">*</span></x-label>
          <x-select id="class_type" wire:model.defer="class_type_id">
            @foreach ($class_types as $class_type)
              <option value="{{ $class_type->id }}">{{ $class_type->name }}</option>
            @endforeach
          </x-select>
          <x-input-error for="class_type_id" />
        </div>
      </div>
    </x-slot>

    <x-slot name="footer">
      <x-button value="dark" wire:click="cancel">Close</x-button>
      <x-button value="submit" wire:click.prevent="store">Save</x-button>
    </x-slot>
  </x-confirmation-modal>

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
