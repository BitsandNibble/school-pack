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
          <th></th>
        </tr>
      </thead>

      <tbody>
        @forelse ($students as $student)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $student->fullname }} </td>
            <td>{{ $student->school_id }}</td>
            <td>{{ $student->gender }}</td>
            <td>
              <x-button class="px-0" value="" wire:click="showInfo({{ $student->id }})"
                        data-bs-toggle="modal" data-bs-target="#infoModal">
                <i class="bx bxs-show"></i>
              </x-button>
              <x-button class="px-0" value="" wire:click="showInfo({{ $student->id }})"
                        data-bs-toggle="modal" data-bs-target="#infoModal">
                <i class="bx bxs-plus-circle"></i>
              </x-button>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" align="center">No record found</td>
          </tr>
        @endforelse
      </tbody>
    </x-responsive-table>

    {{ $students->links() }}
  </x-card>

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

  <x-spinner />
</div>
