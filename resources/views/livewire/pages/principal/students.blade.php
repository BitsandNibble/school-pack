<div>
  <x-breadcrumb>
    Students
    <li class="breadcrumb-item active" aria-current="page">View Students</li>
  </x-breadcrumb>

  <x-card>
    <div class="d-flex align-items-center">
      {{-- <h4 class="my-1">JSS1</h4> --}}


      <div class="ms-auto d-flex justify-content-end">
        <x-button data-bs-toggle="modal" data-bs-target="#studentModal">Add New Student</x-button>
      </div>
    </div>
  </x-card>

  <x-card>
    <div class="row pricing-table">
      <div class="col-md-4">
        <x-card wire:click="$emit('fetchAll')" class="cursor-pointer">
          <div class="d-flex align-items-center">
            <h4 class="my-1">All</h4>
            <div class="ms-auto d-flex justify-content-end">
              <i class='bx bxs-down-arrow-circle font-22'></i>
            </div>
          </div>
        </x-card>
      </div>
      @foreach ($classes as $class)
        <div class="col-md-4 col-sm-6">
          <x-card wire:click="$emit('filterStudents', {{ $class->id }})" class="cursor-pointer">
            <div class="d-flex align-items-center">
              <h4 class="my-1">{{ $class->name }}</h4>
              <div class="ms-auto d-flex justify-content-end">
                <i class='bx bxs-down-arrow-circle font-22'></i>
              </div>
            </div>
          </x-card>
        </div>
      @endforeach
    </div>
  </x-card>

    <livewire:pages.principal.student :id="null" :type="null" />

  <x-modal id="studentModal">
    <x-slot name="title">{{ isset($this->student_id) ? 'Edit' : 'Add New' }} Student</x-slot>

    <x-slot name="content">
      <form>
        <p><span class="text-danger">*</span> fields are required</p>

        <div class="row">
          {{--          <x-validation-errors />--}}

          <div class="col-md-4 mb-2">
            <x-label for="fullname">Full Name <span class="text-danger">*</span></x-label>
            <x-input type="text" id="fullname" wire:model.defer="student.fullname" />
            <x-input-error for="student.fullname" />
          </div>

          <div class="col-md-4 mb-2">
            <x-label for="class">Class <span class="text-danger">*</span></x-label>
            <x-select id="class" wire:model="class">
              @foreach ($classes as $class)
                <option value="{{ $class->id }}">{{ $class->name }}</option>
              @endforeach
            </x-select>
            <x-input-error for="class" />
          </div>

          <div class="col-md-4 mb-2">
            <x-label for="section">Section <span class="text-danger">*</span></x-label>
            <x-select id="section" wire:model.defer="section">
              @if(count($sections) > 0)
                @foreach ($sections as $section)
                  <option value="{{ $section->id }}">{{ $section->name }}</option>
                @endforeach
              @endif
            </x-select>
            <x-input-error for="section" />
          </div>
        </div>

        <div class="row">
          <div class="col-md-4 mb-2">
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
  </x-modal>

  <x-modal id="infoModal">
    <x-slot name="title">Student</x-slot>

    <x-slot name="content">
      <x-table class="table-borderless table-hover">
        <x-slot name="head"></x-slot>

        <x-slot name="body">
          @if($student_info)
            @foreach($student_info as $info)
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
                <x-table.heading>Admission No.</x-table.heading>
                <x-table.cell>{{ $info->school_id }}</x-table.cell>
              </x-table.row>
              <x-table.row>
                <x-table.heading>Current Class</x-table.heading>
                <x-table.cell>
                  {{ $info->class_room->name . ' ' . $info->section->name }}
                </x-table.cell>
              </x-table.row>
              <x-table.row>
                <x-table.heading>Subjects</x-table.heading>
                <x-table.cell>
                  @if(isset($offered_subjects))
                    <ul>
                      @foreach($offered_subjects as $sub)
                        <li>{{ $sub->subject->name }}</li>
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

  <x-confirmation-modal id="deleteModal">
    <x-slot name="title">Delete Student</x-slot>

    <x-slot name="content">
      Are you sure you want to delete this student?
    </x-slot>

    <x-slot name="footer">
      <x-button value="dark" wire:click="cancel">Cancel</x-button>
      <x-button value="danger" wire:click.prevent="delete({{ $deleting }})">Delete</x-button>
    </x-slot>
  </x-confirmation-modal>

  <x-spinner />
</div>
