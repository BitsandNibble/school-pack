<div>
  <h4>Students</h4>

  <x-card>
    <div class="d-flex align-items-center">
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
        <x-input type="search" placeholder="Search" wire:model.deboounce.500ms="q" class="mb-3" />
      </div>
    </div>
    <x-responsive-table class="table-bordered">
      <x-slot name="head">
        <x-table.heading>S/N</x-table.heading>
        <x-table.heading sortable wire:click="sortBy('fullname')" :direction="$sorts['fullname'] ?? null">Full Name
        </x-table.heading>
        <x-table.heading sortable wire:click="sortBy('school_id')" :direction="$sorts['school_id'] ?? null">Admission
          No.
        </x-table.heading>
        <x-table.heading sortable wire:click="sortBy('gender')" :direction="$sorts['gender'] ?? null">Gender
        </x-table.heading>
        <x-table.heading></x-table.heading>
      </x-slot>

      <x-slot name="body">
        @forelse ($students as $student)
          <x-table.row>
            <x-table.cell>{{ $loop->iteration }}</x-table.cell>
            <x-table.cell>{{ $student->fullname }} </x-table.cell>
            <x-table.cell>{{ $student->school_id }}</x-table.cell>
            <x-table.cell>{{ $student->gender }}</x-table.cell>
            <x-table.cell>
              <x-button class="px-0" value="" wire:click="showInfo({{ $student->id }})"
                        data-bs-toggle="modal" data-bs-target="#infoModal">
                <i class="bx bxs-show"></i>
              </x-button>
              <x-button class="px-0" value="" wire:click="showInfo({{ $student->id }})"
                        data-bs-toggle="modal" data-bs-target="#infoModal">
                <i class="bx bxs-plus-circle"></i>
              </x-button>
            </x-table.cell>
          </x-table.row>
        @empty
          <x-table.row>
            <x-table.cell colspan="5" align="center">No record found</x-table.cell>
          </x-table.row>
        @endforelse
      </x-slot>
    </x-responsive-table>

    {{ $students->links() }}
  </x-card>

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

  <x-spinner />
</div>
