<div>
  <x-flash />

  @if ($parent != '2')
    <h5>{{ $title }}</h5>
  @endif

  @if ($parent == '2')
    <x-card>
      <div class="d-flex align-items-center">
        <h4 class="my-1">{{ $class->name }}</h4>

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
        <x-input type="search" placeholder="Search" wire:model.deboounce.500ms="q" />
      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-striped table-sm" style="width:100%">
        <thead>
          <tr>
            <th>S/N</th>
            <th wire:click="sortBy('fullname')" class="cursor-pointer">
              <div class="d-flex justify-content-between">
                Full Name
                <x-sort-icon sortField="fullname" :sortBy="$sortBy" :sortAsc="$sortAsc" />
              </div>
            </th>
            <th wire:click="sortBy('school_id')" class="cursor-pointer">
              <div class="d-flex justify-content-between">
                Admission No
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
              <th>Class</th>
            @endif
            @if ($parent != '2')
              <th></th>
            @endif
          </tr>
        </thead>

        <tbody>
          @forelse ($students as $student)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $student->fullname }} </td>
              <td>{{ $student->school_id }}</td>
              <td>{{ $student->gender }}</td>
              @if (!$class_id)
                <td>
                  @forelse ($student->sections as $section)
                    {{ $current_class = $section->class_room->name . ' ' . $section->name }}
                  @empty
                    <p class="mb-0 text-center">{{ '--------' }}</p>
                  @endforelse
                </td>
              @endif
              @if ($parent != '2')
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
              <td colspan="5" align="center">No record found</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
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

  <x-spinner />
</div>
