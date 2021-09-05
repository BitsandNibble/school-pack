<div>
  <x-breadcrumb>Teachers</x-breadcrumb>
  <x-flash />

  <x-card>
    <div class="d-flex align-items-center">
      {{-- <h4 class="my-1">Class</h4> --}}

      <div class="ms-auto d-flex justify-content-end">
        <x-button data-bs-toggle="modal" data-bs-target="#teacherModal">Add New Teacher</x-button>
      </div>
    </div>
  </x-card>

  <x-card>
    <div class="d-flex align-items-center">
      {{-- <h4 class="my-1">Class</h4> --}}

      <div class="ms-auto d-flex justify-content-end">
        <x-input type="search" placeholder="Search" wire:model.deboounce.500ms="q" class="mb-3" />
      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-striped table-bordered" style="width:100%">
        <thead>
          <tr>
            <th>S/N</th>
            <th>Title</th>
            <th>Full name</th>
            <th>Staff ID</th>
            <th>Email</th>
            <th>Number</th>
            <th>Class</th>
            <th></th>
          </tr>
        </thead>

        <tbody>
          @forelse ($teachers as $teacher)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $teacher->title }}</td>
              <td>{{ $teacher->fullname }} </td>
              <td>{{ $teacher->staff_id }}</td>
              <td>{{ $teacher->email }}</td>
              <td>{{ $teacher->phone_number }}</td>
              <td>
                @forelse ($teacher->classRooms as $class)
                  {{ $class->name }}
                @empty
                  --------
                @endforelse
              </td>
              <td>
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
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8" align="center">No record found</td>
            </tr>
          @endforelse
        </tbody>
      </table>

      {{ $teachers->links() }}
    </div>

  </x-card>

  <x-modal id="teacherModal">
    <x-slot name="title">{{ isset($this->teacher_id) ? 'Edit' : 'Add New' }} Teacher</x-slot>

    <x-slot name="content">
      <form>
        <p><span class="text-danger">*</span> fields are required</p>

        <div class="row">
          {{-- <x-validation-errors /> --}}

          <div class="col-md-4">
            <x-input type="hidden" wire:model="teacher_id" />
            <x-label for="firstname">First name <span class="text-danger">*</span></x-label>
            <x-input type="text" id="firstname" wire:model.defer="teacher.firstname" />
            <x-input-error for="teacher.firstname" />
          </div>

          <div class="col-md-4 mt-2">
            <x-label for="middlename">Middle name</x-label>
            <x-input type="text" id="middlename" wire:model.defer="teacher.middlename" />
          </div>

          <div class="col-md-4 mt-2">
            <x-label for="lastname">Last name <span class="text-danger">*</span></x-label>
            <x-input type="text" id="lastname" wire:model.defer="teacher.lastname" />
            <x-input-error for="teacher.lastname" />
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-md-4">
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

          <div class="col-md-4 mt-2">
            <x-label for="gender">Gender</x-label>
            <x-select id="gender" wire:model.defer="teacher.gender">
              <option value="Male">Male</option>
              <option value="Female">Female</option>
              <option value="Other">Other</option>
            </x-select>
          </div>

          <div class="col-md-4 mt-2">
            <x-label for="class_id">Class</x-label>
            @if (isset($this->teacher_id) && $this->selected_class_id != '')
              <div class="d-flex justify-content">
                <h6 class="mr-4">{{ $existingClass }}</h6>
                <a class="text-dark" href="javascript:;"
                  wire:click.prevent="deleteExistingClass({{ $this->selected_class_id }})">
                  <i class="bx bxs-trash-alt"></i>
                </a>
              </div>
            @else
              <x-select id="class_id" wire:model.defer="teacher.class_id">
                @foreach ($classes as $class)
                  <option value="{{ $class->id }}">{{ $class->name }}</option>
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

  <x-modal id="infoModal">
    <x-slot name="title">Teacher</x-slot>

    <x-slot name="content">
      <table class="table table-sm table-borderless table-hover">
        <tr>
          <th>Fullname</th>
          <td>{{ $teacherInfo['firstname'] ?? '' }} {{ $teacherInfo['middlename'] ?? '' }}
            {{ $teacherInfo['lastname'] ?? '' }}</td>
        </tr>
        <tr>
          <th>Email</th>
          <td>{{ $teacherInfo['email'] ?? '' }}</td>
        </tr>
        <tr>
          <th>Phone Number</th>
          <td>{{ $teacherInfo['phone_number'] ?? '' }}</td>
        </tr>
        <tr>
          <th>Gender</th>
          <td>{{ $teacherInfo['gender'] ?? '' }}</td>
        </tr>
        <tr>
          <th>Date of Birth</th>
          <td>{{ $teacherInfo['date_of_birth'] ?? '' }}</td>
        </tr>
        <tr>
          <th>Staff ID</th>
          <td>{{ $teacherInfo['staff_id'] ?? '' }}</td>
        </tr>
        <tr>
          <th>Class Teacher</th>
          <td>{{ $teacherClassInfo ?? '' }}</td>
        </tr>
        <tr>
          <th>Subjects</th>
          {{-- <td>{{ $teacherClassInfo ?? '' }}</td> --}}
        </tr>
      </table>
    </x-slot>

    <x-slot name="footer">
      <x-button value="dark" wire:click="cancel">Close</x-button>
    </x-slot>
  </x-modal>

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
