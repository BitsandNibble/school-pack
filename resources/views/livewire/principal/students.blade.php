<div>
  <x-breadcrumb>Students</x-breadcrumb>

  <x-flash />
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

  <livewire:principal.student :id="null" :type="null" />

  <x-modal id="studentModal">
    <x-slot name="title">{{ isset($this->student_id) ? 'Edit' : 'Add New' }} Student</x-slot>

    <x-slot name="content">
      <form>
        <p><span class="text-danger">*</span> fields are required</p>

        <div class="row">
          <x-validation-errors />

          <div class="col-md-4">
            <x-input type="hidden" wire:model="student_id" />
            <x-label for="firstname">First name <span class="text-danger">*</span></x-label>
            <x-input type="text" id="firstname" wire:model.defer="student.firstname" />
            <x-input-error for="student.firstname" />
          </div>

          <div class="col-md-4 mt-2">
            <x-label for="middlename">Middle name</x-label>
            <x-input type="text" id="middlename" wire:model.defer="student.middlename" />
          </div>

          <div class="col-md-4 mt-2">
            <x-label for="lastname">Last name <span class="text-danger">*</span></x-label>
            <x-input type="text" id="lastname" wire:model.defer="student.lastname" />
            <x-input-error for="student.lastname" />
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-md-4">
            <x-label for="previous_class">Previous Class</x-label>
            <x-select id="previous_class" wire:model.defer="student.previous_class">
              @foreach ($classes as $class)
                <option value="{{ $class->name }}">{{ $class->name }}</option>
              @endforeach
            </x-select>
          </div>

          <div class="col-md-4 mt-2">
            <x-label for="current_class">Current Class <span class="text-danger">*</span></x-label>
            <x-select id="current_class" wire:model.defer="student.current_class">
              @foreach ($classes as $class)
                <option value="{{ $class->id }}">{{ $class->name }}</option>
              @endforeach
            </x-select>
            <x-input-error for="student.current_class" />
          </div>

          <div class="col-md-4 mt-2">
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
    <x-slot name="title">Teacher</x-slot>

    <x-slot name="content">
      <table class="table table-sm table-borderless table-hover">
        <tr>
          <th>Fullname</th>
          <td>{{ $studentInfo['firstname'] ?? '' }} {{ $studentInfo['middlename'] ?? '' }}
            {{ $studentInfo['lastname'] ?? '' }}</td>
        </tr>
        <tr>
          <th>Email</th>
          <td>{{ $studentInfo['email'] ?? '' }}</td>
        </tr>
        <tr>
          <th>Phone Number</th>
          <td>{{ $studentInfo['phone_number'] ?? '' }}</td>
        </tr>
        <tr>
          <th>Gender</th>
          <td>{{ $studentInfo['gender'] ?? '' }}</td>
        </tr>
        <tr>
          <th>Date of Birth</th>
          <td>{{ $studentInfo['date_of_birth'] ?? '' }}</td>
        </tr>
        <tr>
          <th>Admission No.</th>
          <td>{{ $studentInfo['admission_no'] ?? '' }}</td>
        </tr>
        <tr>
          <th>Previous Class</th>
          <td>{{ $studentInfo['previous_class'] ?? '' }}</td>
        </tr>
        <tr>
          <th>Current Class</th>
          <td>{{ $studentClassInfo ?? '' }}</td>
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
