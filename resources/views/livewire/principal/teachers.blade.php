<div>
  <x-flash />

  <x-card>
    <x-button data-bs-toggle="modal" data-bs-target="#teacherModal">Add New Teacher</x-button>
  </x-card>

  <x-card>
    <div class="table-responsive">
      <table id="teachrsTable" class="table table-striped table-bordered" style="width:100%">
        <thead>
          <tr>
            <th>S/N</th>
            <th>Title</th>
            <th>Full name</th>
            <th>Staff ID</th>
            <th>Email</th>
            <th>Number</th>
            <th>Class Teacher</th>
            <th></th>
          </tr>
        </thead>

        <tbody>
          @foreach ($teachers as $teacher)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $teacher->title }}</td>
              <td>{{ $teacher->fullname }} </td>
              <td>{{ $teacher->staff_id }}</td>
              <td>{{ $teacher->email }}</td>
              <td>{{ $teacher->phone_number }}</td>
              <td class="text-uppercase">
                @foreach (\App\Models\StudentClass::where('id', $teacher->class_id)->get() as $class)
                  {{ $class->name }}
                @endforeach
              </td>
              <td>
                <x-button wire:click.prevent="delete({{ $teacher->id }})"
                  onclick="confirm('Are you sure you want to delete this teacher?') || event.stopImmediatePropagation()"
                  class="btn-sm" value="">
                  <i class="bx bx-trash-alt"></i>
                </x-button>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>

      {{ $teachers->links() }}
    </div>

  </x-card>

  <x-modal id="teacherModal">
    <x-slot name="title">Add New Teacher</x-slot>

    <x-slot name="content">
      <form>
        <p><span class="text-danger">*</span> fields are required</p>

        <div class="row">
          {{-- <x-validation-errors /> --}}

          <div class="col-md-4">
            <x-label for="firstname">First name <span class="text-danger">*</span></x-label>
            <x-input type="text" id="firstname" wire:model.defer="teacher.firstname" />
            <x-input-error for="teacher.firstname" custom-message="The firstname is required" />
          </div>

          <div class="col-md-4">
            <x-label for="middlename">Middle name</x-label>
            <x-input type="text" id="middlename" wire:model.defer="teacher.middlename" />
          </div>

          <div class="col-md-4">
            <x-label for="lastname">Last name <span class="text-danger">*</span></x-label>
            <x-input type="text" id="lastname" wire:model.defer="teacher.lastname" />
            <x-input-error for="teacher.lastname" custom-message="The lastname is required" />
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
            <x-input-error for="teacher.title" custom-message="The title is required" />
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
            <x-label for="class_id">Class</x-label>
            <x-select id="class_id" wire:model.defer="teacher.class_id">
              @foreach ($classes as $class)
                <option value="{{ $class->id }}">{{ $class->name }}</option>
              @endforeach
            </x-select>
          </div>
        </div>
      </form>
    </x-slot>

    <x-slot name="footer">
      <x-button value="dark" wire:click="close">Close</x-button>
      <x-button value="submit" wire:click.prevent="store">Save</x-button>
    </x-slot>
  </x-modal>
</div>
