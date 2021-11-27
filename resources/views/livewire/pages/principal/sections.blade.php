<div>
  <x-breadcrumb>
    Classes
    <li class="breadcrumb-item active" aria-current="page">Sections</li>
  </x-breadcrumb>

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


      <div class="ms-auto d-flex justify-content-end">
        @if ($selected)
          <x-dropdown class="me-3">
            <x-slot name="title">Bulk Actions</x-slot>

            <li>
              <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#deleteSelectedModal" href="#">
                <i class="bx bxs-trash"></i>
                Delete
              </a>
            </li>
            <li><a class="dropdown-item" href="#">Archive</a></li>
            <li><a class="dropdown-item" href="#">Export</a></li>
            {{-- <x-button value="success" wire:click="exportSelected" class="float-end">Export</x-button> --}}
          </x-dropdown>
        @endif

        <x-input type="search" size="sm" placeholder="Search" wire:model.deboounce.500ms="q" />
      </div>
    </div>

    <x-responsive-table>
      <thead>
        <tr>
          <th class="pe-0" style="width: 30px">
            <x-checked-input type="checkbox" wire:model="selectPage" />
          </th>
          <th>S/N</th>
          <x-table.heading sortable wire:click="sortBy('class_room_id')" :direction="$sorts['class_room_id'] ?? null">
            Class
          </x-table.heading>
          <x-table.heading sortable wire:click="sortBy('name')" :direction="$sorts['name'] ?? null">Section
          </x-table.heading>
          <x-table.heading sortable wire:click="sortBy('teacher_id')" :direction="$sorts['teacher_id'] ?? null">
            Teacher
          </x-table.heading>
          <th></th>
        </tr>
      </thead>

      <tbody>
        @if ($selectPage)
          <tr class="bg-gradient-lush">
            <td colspan="6">
              @unless($selectAll)
                <div>
                  You have selected <strong>{{ $sections->count() }}</strong> section(s)
                  @if ($sections->count() !== $sections->total()), do you want to select
                  all
                  <strong>{{ $sections->total() }}</strong>?
                  <x-button-link wire:click="selectAll">Select All</x-button-link>
                  @endif
                </div>
              @else
                You have selected all <strong>{{ $sections->total() }}</strong> sections.
              @endunless
            </td>
          </tr>
        @endif

        @forelse($sections as $section)
          <tr wire.key="row-{{ $section->id }}">
            <td class="pe-0">
              <x-checked-input type="checkbox" wire:model="selected" value="{{ $section->id }}" />
            </td>
            <td>{{ $loop->iteration }}</td>
            <td style="transform: rotate(0);">
              <a href="{{ route('principal.classes.students', [$section->class_room->slug]) }}"
                 class="stretched-link">
                {{ $section->class_room->name }}
              </a>
            </td>
            <td style="transform: rotate(0);">
              <a href="{{ route('principal.sections.students', [$section->class_room->slug, $section]) }}"
                 class="stretched-link">
                {{ $section->name }}
              </a>
            </td>
            <td>{{ $section->teacher->fullname }}</td>
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
            <td colspan="6" class="text-center">No record found</td>
          </tr>
        @endforelse
      </tbody>
    </x-responsive-table>

    {{ $sections->links() }}
  </x-card>


  <x-confirmation-modal id="sectionModal">
    <x-slot name="title">{{ isset($this->section_id) ? 'Edit' : 'Add New' }} Section</x-slot>

    <x-slot name="content">
      <p><span class="text-danger">*</span> fields are required</p>

      <div class="row">
        {{-- <x-validation-errors /> --}}

        <div class="col">
          <x-label for="class">Class <span class="text-danger">*</span></x-label>
          <x-select id="class" wire:model.defer="class">
            @foreach ($classes as $class)
              <option value="{{ $class->id }}">{{ $class->name }}</option>
            @endforeach
          </x-select>
          <x-input-error for="class" />
        </div>

        <div class="col mb-2">
          <x-label for="name">Name <span class="text-danger">*</span></x-label>
          <x-input type="text" id="name" wire:model.defer="name" />
          <x-input-error for="name" />
        </div>

        <div class="col">
          <x-label for="teacher_id">Class Teacher</x-label>
          <x-select id="teacher_id" wire:model.defer="teacher_id">
            @foreach ($teachers as $teacher)
              <option value="{{ $teacher->id }}">{{ $teacher->fullname }}</option>
            @endforeach
          </x-select>
        </div>
      </div>
    </x-slot>

    <x-slot name="footer">
      <x-button value="dark" wire:click="cancel">Close</x-button>
      <x-button value="submit" wire:click.prevent="store">Save</x-button>
    </x-slot>
  </x-confirmation-modal>

  <x-confirmation-modal id="deleteSelectedModal">
    <x-slot name="title">Delete Section</x-slot>

    <x-slot name="content">
      Are you sure you want to delete these sections? This action is irreversible.
    </x-slot>

    <x-slot name="footer">
      <x-button value="dark" wire:click="cancel">Cancel</x-button>
      <x-button value="danger" wire:click.prevent="deleteSelected">Delete</x-button>
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
