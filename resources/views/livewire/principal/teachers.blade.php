<x-card>
  <x-button data-bs-toggle="modal" data-bs-target="#teacherModal">Add New Teacher</x-button>
  {{-- <x-button wire:click="confirmTeacherAdd">Add New Teacher</x-button> --}}
</x-card>

<x-card>
  @foreach ($teachers as $teacher)
    {{ $teacher }}
  @endforeach
</x-card>


@push('modals')
  <x-modal id="teacherModal">
    <x-slot name="title">Add New Teacher</x-slot>

    <x-slot name="content">
      <p><span class="text-danger">*</span> fields are required</p>
      <div class="row">
        <x-validation-errors />
        <div class="col-md-4">
          <x-label for="firstname">First name <span class="text-danger">*</span></x-label>
          <x-input type="text" id="firstname" wire:model.defer="teacher.firstname" />
          <x-input-error for="firstname" />
        </div>

        <div class="col-md-4">
          <x-label for="middlename">Middle name</x-label>
          <x-input type="text" id="middlename" wire:model.defer="teacher.middlename" />
          <x-input-error for="middlename" />
        </div>

        <div class="col-md-4">
          <x-label for="lastname">Last name <span class="text-danger">*</span></x-label>
          <x-input type="text" id="lastname" wire:model.defer="teacher.lastname" />
          <x-input-error for="lastname" />
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
          </x-select>
        </div>

        <div class="col-md-4">
          <x-label for="gender">Gender</x-label>
          <x-select id="gender" wire:model.defer="teacher.gender">
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
          </x-select>
        </div>

        <div class="col-md-4">
          <x-label for="class_teacher">Class Teacher</x-label>
          <x-select id="class_teacher" wire:model.defer="teacher.class_teacher">
            <option value="JSS1">JSS1</option>
            <option value="JSS2">JSS2</option>
            <option value="JSS3">JSS3</option>
          </x-select>
        </div>

        {{-- <div class="col-md-3">
              <x-label for="staff_id">Staff ID</x-label>
              <x-input disabled />
            </div> --}}
      </div>
    </div>

    <x-slot name="footer">
      <x-button value="submit" wire:click="saveTeacher">Add</x-button>
    </x-slot>
  </x-modal>
@endpush
