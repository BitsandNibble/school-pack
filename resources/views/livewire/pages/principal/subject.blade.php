<div>
  <x-flash />

  <x-card>
    <div class="d-flex align-items-center">
      <h4 class="my-1">{{ $class->name }}</h4>

      <div class="ms-auto d-flex justify-content-end">
        <x-button data-bs-toggle="modal" data-bs-target="#subjectTeacherModal">Add Subject & Teacher</x-button>
      </div>
    </div>
  </x-card>

  <x-card>
    <div class="d-flex align-items-center">
      <div class="ms-auto d-flex justify-content-end">
        <x-input type="search" placeholder="Search" wire:model.deboounce.500ms="q" class="mb-3" />
      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-striped table-sm" style="width:100%">
        <thead>
          <tr>
            <th>S/N</th>
            <th>Subject Name</th>
            <th>Subject Teacher</th>
            <th></th>
          </tr>
        </thead>

        <tbody>
          @forelse($classes as $class)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>
                @foreach (\App\Models\Subject::where('id', $class->subject_id)->get() as $subject)
                  {{ $subject->name }}
                @endforeach
              </td>
              <td>
                @foreach (\App\Models\Teacher::where('id', $class->teacher_id)->get() as $teacher)
                  {{ $teacher->fullname }}
                @endforeach
              </td>
              <td>
                <x-button class="px-0" wire:click="edit({{ $class->id }})" value=""
                          data-bs-toggle="modal" data-bs-target="#subjectTeacherModal">
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
              <td colspan="5" align="center">No record found</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </x-card>

  <x-modal id="subjectTeacherModal">
    <x-slot name="title">{{ isset($this->subject_id) ? 'Edit' : 'Add ' }} Subject & Teacher</x-slot>

    <x-slot name="content">
      <form>
        <p><span class="text-danger">*</span> fields are required</p>

        <div class="row">
          {{--          <x-validation-errors />--}}

          <div class="col mb-2">
            <x-input type="hidden" wire:model="class_subject_teacher" />
            <x-label for="subject">Subject <span class="text-danger">*</span></x-label>
            <x-select id="subject" wire:model.defer="subject">
              @foreach ($availableSubjects as $availableSubject)
                <option value="{{ $availableSubject->id }}">{{ $availableSubject->name }}</option>
              @endforeach
            </x-select>
            <x-input-error for="subject" />
          </div>

          <div class="col mb-2">
            <x-label for="teacher">Teacher <span class="text-danger">*</span></x-label>
            <x-select id="teacher" wire:model.defer="teacher">
              @foreach ($allTeachers as $teacher)
                <option value="{{ $teacher->id }}">{{ $teacher->fullname }}</option>
              @endforeach
            </x-select>
            <x-input-error for="teacher" />
          </div>
        </div>
      </form>
    </x-slot>

    <x-slot name="footer">
      <x-button value="dark" wire:click="cancel">Close</x-button>
      <x-button value="submit" wire:click.prevent="store">Save</x-button>
    </x-slot>
  </x-modal>

  <x-confirmation-modal id="deleteModal">
    <x-slot name="title">Delete Subject Teacher</x-slot>

    <x-slot name="content">
      Are you sure you want to delete this subject & teacher?
    </x-slot>

    <x-slot name="footer">
      <x-button value="dark" wire:click="cancel">Cancel</x-button>
      <x-button value="danger" wire:click.prevent="delete({{ $deleting }})">Delete</x-button>
    </x-slot>
  </x-confirmation-modal>

  <x-spinner />
</div>
