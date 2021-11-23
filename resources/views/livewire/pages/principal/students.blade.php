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
        @if($student_info)
          @foreach($student_info as $info)
            <tr>
              <th>Fullname</th>
              <td>{{ $info->fullname }}</td>
            </tr>
            <tr>
              <th>Email</th>
              <td>{{ $info->email }}</td>
            </tr>
            <tr>
              <th>Address</th>
              <td>{{ $info->address }}</td>
            </tr>
            <tr>
              <th>Phone Number</th>
              <td>{{ $info->phone_number }}</td>
            </tr>
            <tr>
              <th>Gender</th>
              <td>{{ $info->gender }}</td>
            </tr>
            <tr>
              <th>Nationality</th>
              <td>{{ $info->nationality->name }}</td>
            </tr>
            <tr>
              <th>State</th>
              <td>{{ $info->state->name }}</td>
            </tr>
            <tr>
              <th>LGA</th>
              <td>{{ $info->lga->name }}</td>
            </tr>
            <tr>
              <th>Date of Birth</th>
              <td>{{ $info->date_of_birth }}</td>
            </tr>
            <tr>
              <th>Admission No.</th>
              <td>{{ $info->school_id }}</td>
            </tr>
            <tr>
              <th>Current Class</th>
              <td>
                {{ $info->class_room->name . ' ' . $info->section->name }}
              </td>
            </tr>
            <tr>
              <th>Subjects</th>
              <td>
                @if(isset($offered_subjects))
                  <ul>
                    @foreach($offered_subjects as $sub)
                      <li>{{ $sub->subject->name }}</li>
                    @endforeach
                  </ul>
                @endif
              </td>
            </tr>
          @endforeach
        @endif
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
