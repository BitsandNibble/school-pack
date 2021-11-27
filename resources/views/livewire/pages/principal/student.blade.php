<div>
  @if ($parent !== 2)
    <h5>{{ $title }}</h5>
  @endif

  @if ($parent === 2)
    <x-card>
      <div class="d-flex align-items-center">
        <h4 class="my-1">{{ $class_name }}</h4>

        <div class="ms-auto d-flex justify-content-end">
          <x-button data-bs-toggle="modal" data-bs-target="#studentModal2">Add New Student</x-button>
        </div>
      </div>
    </x-card>
  @endif

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
          <th wire:click="sortBy('fullname')" class="cursor-pointer">
            <div class="d-flex justify-content-between">
              Name
              <x-sort-icon sortField="fullname" :sortBy="$sortBy" :sortAsc="$sortAsc" />
            </div>
          </th>
          <th wire:click="sortBy('school_id')" class="cursor-pointer">
            <div class="d-flex justify-content-between">
              Adm. No
              <x-sort-icon sortField="school_id" :sortBy="$sortBy" :sortAsc="$sortAsc" />
            </div>
          </th>
          <th wire:click="sortBy('gender')" class="cursor-pointer">
            <div class="d-flex justify-content-between">
              Gender
              <x-sort-icon sortField="gender" :sortBy="$sortBy" :sortAsc="$sortAsc" />
            </div>
          </th>
          @if (!$class_id)
            <th wire:click="sortBy('class_room_id')" class="cursor-pointer">
              <div class="d-flex justify-content-between">
                Class
                <x-sort-icon sortField="class_room_id" :sortBy="$sortBy" :sortAsc="$sortAsc" />
              </div>
            </th>
          @else
            <th wire:click="sortBy('section_id')" class="cursor-pointer">
              <div class="d-flex justify-content-between">
                Section
                <x-sort-icon sortField="section_id" :sortBy="$sortBy" :sortAsc="$sortAsc" />
              </div>
            </th>
          @endif
          @if ($parent === null)
            <th></th>
          @endif
        </tr>
      </thead>

      <tbody>
        @if ($selectPage)
          <tr class="bg-gradient-lush">
            <td colspan="7">
              @unless($selectAll)
                <div>
                  You have selected <strong>{{ $students->count() }}</strong> student(s)
                  @if ($students->count() !== $students->total()), do you want to select
                  all
                  <strong>{{ $students->total() }}</strong>?
                  <x-button-link wire:click="selectAll">Select All</x-button-link>
                  @endif
                </div>
              @else
                You have selected all <strong>{{ $students->total() }}</strong> students.
              @endunless
            </td>
          </tr>
        @endif

        @forelse ($students as $student)
          <tr wire.key="row-{{ $student->id }}">
            <td class="pe-0">
              <x-checked-input type="checkbox" wire:model="selected" value="{{ $student->id }}" />
            </td>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $student->fullname }} </td>
            <td>{{ $student->school_id }}</td>
            <td>{{ $student->gender }}</td>
            @if (!$class_id)
              <td>
                {{ $student->class_room->name }} {{ $student->section->name }}
              </td>
            @else
              <td>
                {{ $student->section->name }}
              </td>
            @endif
            @if ($parent === null)
              <td>
                <x-button class="px-0" value="" wire:click="$emit('showInfo', {{ $student->id }})"
                          data-bs-toggle="modal" data-bs-target="#infoModal">
                  <i class="bx bxs-show"></i>
                </x-button>
                <x-button class="px-0" wire:click="$emit('edit', {{ $student->id }})" value=""
                          data-bs-toggle="modal" data-bs-target="#studentModal">
                  <i class="bx bxs-pen"></i>
                </x-button>
                <x-button class="px-0" value="" wire:click="$emit('openDeleteModal', {{ $student->id }})"
                          data-bs-toggle="modal" data-bs-target="#deleteModal">
                  <i class="bx bxs-trash-alt"></i>
                </x-button>
              </td>
            @endif
          </tr>
        @empty
          <tr>
            <td colspan="7" class="text-center">No record found</td>
          </tr>
        @endforelse
      </tbody>
    </x-responsive-table>

    {{ $students->links() }}
  </x-card>

  <x-confirmation-modal id="studentModal2">
    <x-slot name="title">Add New Student</x-slot>

    <x-slot name="content">
      <form>
        <p><span class="text-danger">*</span> fields are required</p>

        <div class="row">
          {{--          <x-validation-errors />--}}

          <div class="col-md-6 mb-2">
            <x-label for="fullname">Full Name <span class="text-danger">*</span></x-label>
            <x-input type="text" id="fullname" wire:model.defer="student.fullname" />
            <x-input-error for="student.fullname" />
          </div>

          <div class="col-md-6 mb-2">
            <x-label for="gender">Gender</x-label>
            <x-select id="gender" wire:model.defer="student.gender">
              <option value="Male">Male</option>
              <option value="Female">Female</option>
              <option value="Other">Other</option>
            </x-select>
          </div>
        </div>
      </form>
    </x-slot>

    <x-slot name="footer">
      <x-button value="dark" wire:click="cancel">Close</x-button>
      <x-button value="submit" wire:click.prevent="store">Save</x-button>
    </x-slot>
  </x-confirmation-modal>

  <x-confirmation-modal id="deleteSelectedModal">
    <x-slot name="title">Delete Teacher</x-slot>

    <x-slot name="content">
      Are you sure you want to delete these teachers? This action is irreversible.
    </x-slot>

    <x-slot name="footer">
      <x-button value="dark" wire:click="cancel">Cancel</x-button>
      <x-button value="danger" wire:click.prevent="deleteSelected">Delete</x-button>
    </x-slot>
  </x-confirmation-modal>

  <x-spinner />
</div>
