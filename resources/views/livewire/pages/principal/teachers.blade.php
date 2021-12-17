<div>
  <x-breadcrumb>Teachers</x-breadcrumb>

  <x-card>
    <div class="d-flex align-items-center">
      {{-- <h4 class="my-1">Class</h4> --}}

      <div class="ms-auto d-flex justify-content-end">
        <x-button data-bs-toggle="modal" data-bs-target="#teacherModal">Add New Teacher</x-button>
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
      <x-slot name="head">
        <x-table.heading class="pe-0" style="width: 30px">
          <x-checked-input type="checkbox" wire:model="selectPage" />
        </x-table.heading>
        <x-table.heading>S/N</x-table.heading>
        <x-table.heading sortable wire:click="sortBy('title')" :direction="$sorts['title'] ?? null">Title
        </x-table.heading>
        <x-table.heading sortable wire:click="sortBy('fullname')" :direction="$sorts['fullname'] ?? null">Name
        </x-table.heading>
        <x-table.heading sortable wire:click="sortBy('school_id')" :direction="$sorts['school_id'] ?? null">Staff ID
        </x-table.heading>
        <x-table.heading sortable wire:click="sortBy('email')" :direction="$sorts['email'] ?? null">Email
        </x-table.heading>
        <x-table.heading sortable wire:click="sortBy('phone_number')" :direction="$sorts['phone_number'] ?? null">
          Number
        </x-table.heading>
        <x-table.heading></x-table.heading>
      </x-slot>

      <x-slot name="body">
        @if ($selectPage)
          <x-table.row class="bg-gradient-lush">
            <x-table.cell colspan="8">
              @unless($selectAll)
                <div>
                  You have selected <strong>{{ $teachers->count() }}</strong> teacher(s)
                  @if ($teachers->count() !== $teachers->total()), do you want to select
                  all
                  <strong>{{ $teachers->total() }}</strong>?
                  <x-button-link wire:click="selectAll">Select All</x-button-link>
                  @endif
                </div>
              @else
                You have selected all <strong>{{ $teachers->total() }}</strong> teachers.
              @endunless
            </x-table.cell>
          </x-table.row>
        @endif

        @forelse ($teachers as $teacher)
          <x-table.row wire.key="row-{{ $teacher->id }}">
            <x-table.cell class="pe-0">
              <x-checked-input type="checkbox" wire:model="selected" value="{{ $teacher->id }}" />
            </x-table.cell>
            <x-table.cell>{{ $loop->iteration }}</x-table.cell>
            <x-table.cell>{{ $teacher->title }}</x-table.cell>
            <x-table.cell>{{ $teacher->fullname }} </x-table.cell>
            <x-table.cell>{{ $teacher->school_id }}</x-table.cell>
            <x-table.cell>{{ $teacher->email }}</x-table.cell>
            <x-table.cell>{{ $teacher->phone_number }}</x-table.cell>
            <x-table.cell>
              <x-button class="px-0" value="" wire:click="showInfo({{ $teacher->id }})"
                        data-bs-toggle="modal" data-bs-target="#infoModal">
                <i class="bx bxs-show"></i>
              </x-button>
              <x-button class="px-0" wire:click="edit({{ $teacher->id }})" value="" data-bs-toggle="modal"
                        data-bs-target="#teacherModal">
                <i class="bx bxs-pen"></i>
              </x-button>
              <x-button class="px-0" value="" wire:click="openDeleteModal({{ $teacher->id }})"
                        data-bs-toggle="modal" data-bs-target="#deleteModal">
                <i class="bx bxs-trash-alt"></i>
              </x-button>
            </x-table.cell>
          </x-table.row>
        @empty
          <x-table.row>
            <x-table.cell colspan="8" class="text-center">No record found</x-table.cell>
          </x-table.row>
        @endforelse
      </x-slot>
    </x-responsive-table>

    {{ $teachers->links() }}

  </x-card>

  <x-confirmation-modal id="teacherModal">
    <x-slot name="title">{{ isset($this->teacher_id) ? 'Edit' : 'Add New' }} Teacher</x-slot>

    <x-slot name="content">
      <form>
        <p><span class="text-danger">*</span> fields are required</p>

        <div class="row">
          {{-- <x-validation-errors /> --}}

          <div class="col-md-4 mb-2">
            <x-label for="title">Title <span class="text-danger">*</span></x-label>
            <x-select id="title" wire:model.defer="teacher.title">
              <option value="Mr">Mr</option>
              <option value="Mrs">Mrs</option>
              <option value="Ms">Ms</option>
              <option value="Miss">Miss</option>
              <option value="Prof">Prof</option>
              <option value="Asst. Prof">Asst. Prof</option>
              <option value="Dr">Dr</option>
            </x-select>
            <x-input-error for="teacher.title" />
          </div>

          <div class="col-md-8 mb-2">
            <x-label for="fullname">Full Name <span class="text-danger">*</span></x-label>
            <x-input type="text" id="fullname" wire:model.defer="teacher.fullname" />
            <x-input-error for="teacher.fullname" />
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-2">
            <x-label for="email">Email</x-label>
            <x-input type="email" id="email" wire:model.defer="teacher.email" />
            <x-input-error for="teacher.email" />
          </div>

          <div class="col-md-6 mb-2">
            <x-label for="gender">Gender</x-label>
            <x-select id="gender" wire:model.defer="teacher.gender">
              <option value="Male">Male</option>
              <option value="Female">Female</option>
              <option value="Other">Other</option>
            </x-select>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <x-label for="date_of_employment">Date of Employment</x-label>
            <x-input type="date" id="date_of_employment" wire:model.defer="teacher.date_of_employment"></x-input>
            <x-input-error for="teacher.date_of_employment" />
          </div>
        </div>
      </form>
    </x-slot>

    <x-slot name="footer">
      <x-button value="dark" wire:click="cancel">Close</x-button>
      <x-button value="submit" wire:click.prevent="store">Save</x-button>
    </x-slot>
  </x-confirmation-modal>

  <x-modal id="infoModal">
    <x-slot name="title">Teacher</x-slot>

    <x-slot name="content">
      <x-table class="table-borderless table-hover">
        <x-slot name="head"></x-slot>

        <x-slot name="body">
          @if($teacher_info)
            @foreach($teacher_info as $info)
              <x-table.row>
                <x-table.heading>Fullname</x-table.heading>
                <x-table.cell>{{ $info->fullname }}</x-table.cell>
              </x-table.row>
              <x-table.row>
                <x-table.heading>Email</x-table.heading>
                <x-table.cell>{{ $info->email }}</x-table.cell>
              </x-table.row>
              <x-table.row>
                <x-table.heading>Address</x-table.heading>
                <x-table.cell>{{ $info->address }}</x-table.cell>
              </x-table.row>
              <x-table.row>
                <x-table.heading>Phone Number</x-table.heading>
                <x-table.cell>{{ $info->phone_number }}</x-table.cell>
              </x-table.row>
              <x-table.row>
                <x-table.heading>Gender</x-table.heading>
                <x-table.cell>{{ $info->gender }}</x-table.cell>
              </x-table.row>
              <x-table.row>
                <x-table.heading>Nationality</x-table.heading>
                <x-table.cell>{{ $info->nationality->name }}</x-table.cell>
              </x-table.row>
              <x-table.row>
                <x-table.heading>State</x-table.heading>
                <x-table.cell>{{ $info->state->name }}</x-table.cell>
              </x-table.row>
              <x-table.row>
                <x-table.heading>LGA</x-table.heading>
                <x-table.cell>{{ $info->lga->name }}</x-table.cell>
              </x-table.row>
              <x-table.row>
                <x-table.heading>Date of Birth</x-table.heading>
                <x-table.cell>{{ $info->date_of_birth }}</x-table.cell>
              </x-table.row>
              <x-table.row>
                <x-table.heading>Staff ID</x-table.heading>
                <x-table.cell>{{ $info->school_id }}</x-table.cell>
              </x-table.row>
              <x-table.row>
                <x-table.heading>Date of Employment</x-table.heading>
                <x-table.cell>{{ $info->date_of_employment }}</x-table.cell>
              </x-table.row>
              <x-table.row>
                <x-table.heading>Class Teacher</x-table.heading>
                <x-table.cell>{{ $teacher_class_info . $section }}</x-table.cell>
              </x-table.row>
              <x-table.row>
                <x-table.heading>Subjects</x-table.heading>
                <x-table.cell>
                  @if(isset($assigned_subject_id))
                    <ul>
                      @foreach($assigned_subject_id as $sub)
                        <li>{{ $sub->subject->name . ' - ' . $sub->class_room->name }}</li>
                      @endforeach
                    </ul>
                  @endif
                </x-table.cell>
              </x-table.row>
            @endforeach
          @endif
        </x-slot>
      </x-table>
    </x-slot>

    <x-slot name="footer">
      <x-button value="dark" wire:click="cancel">Close</x-button>
    </x-slot>
  </x-modal>

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

  <x-confirmation-modal id="deleteModal">
    <x-slot name="title">Delete Teacher</x-slot>

    <x-slot name="content">
      Are you sure you want to delete this teacher?
    </x-slot>

    <x-slot name="footer">
      <x-button value="dark" wire:click="cancel">Cancel</x-button>
      <x-button value="danger" wire:click.prevent="delete({{ $deleting }})">Delete</x-button>
    </x-slot>
  </x-confirmation-modal>

  <x-spinner />
</div>
