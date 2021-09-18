<div>
  <x-flash />

  <h4>Subjects</h4>

  <x-card class="border-0 border-start border-5 border-primary">
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
            <th wire:click="sortBy('name')" class="cursor-pointer">
              <div class="d-flex justify-content-between">
                Name
                <x-sort-icon sortField="name" :sortBy="$sortBy" :sortAsc="$sortAsc" />
              </div>
            </th>
            <th></th>
          </tr>
        </thead>

        <tbody>
          @forelse($subjects as $subject)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $subject->name }}</td>
              <td>
                <x-button class="px-0" value="" wire:click="subjectName({{ $subject->id }})" data-bs-toggle="modal"
                          data-bs-target="#registerStudentModal">
                  <i class="bx bxs-plus-circle"></i>
                </x-button>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="3" align="center">No record found</td>
            </tr>
          @endforelse
        </tbody>

      </table>
    </div>
  </x-card>

  <x-modal id="registerStudentModal">
    <x-slot name="title">Register Students for {{ $subject_name }}</x-slot>

    <x-slot name="content">
      <form>
        <x-checked-label for="checkAll" class="mb-2 fw-bolder text-dark">
          <x-checked-input type="checkbox" id="checkAll" wire:model="selectAll" />
          Check All
        </x-checked-label>

        @json($fullname)
        <div class="row">
          {{-- <x-validation-errors /> --}}

          @foreach($students as $student)
            <div class="col-md-6 mb-2">
              <x-checked-label for="student_{{ $student->id }}">
                <x-checked-input type="checkbox" value="{{ $student->id }}" wire:model="fullname"
                                 id="student_{{ $student->id }}" />
                {{ $student->fullname }}
              </x-checked-label>
              {{--            <x-input type="hidden" wire:model="teacher_id" />--}}
              <x-input-error for="fullname" />
            </div>
          @endforeach
        </div>
      </form>
    </x-slot>

    <x-slot name="footer">
      <x-button value="dark" wire:click="cancel">Close</x-button>
      <x-button value="submit" wire:click.prevent="store">Save</x-button>
    </x-slot>
  </x-modal>
</div>
