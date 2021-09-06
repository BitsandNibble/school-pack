<div>
  @if ($parent != '2')
    <h5>{{ $title }}</h5>
  @endif

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

    <div class="table-responsive">
      <table class="table table-striped table-bordered" style="width:100%">
        <thead>
          <tr>
            <th>S/N</th>
            <th wire:click="sortBy('fullname')" class="cursor-pointer">
              <div class="d-flex justify-content-between">
                Full Name
                <x-sort-icon sortField="fullname" :sortBy="$sortBy" :sortAsc="$sortAsc" />
              </div>
            </th>
            <th wire:click="sortBy('admission_no')" class="cursor-pointer">
              <div class="d-flex justify-content-between">
                Admission No
                <x-sort-icon sortField="admission_no" :sortBy="$sortBy" :sortAsc="$sortAsc" />
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
              <td>{{ $student->admission_no }}</td>
              <td>{{ $student->gender }}</td>
              @if (!$class_id)
                <td>
                  @forelse ($student->classRooms as $class)
                    {{ $class->name }}
                  @empty
                    --------
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

  <x-spinner />
</div>
