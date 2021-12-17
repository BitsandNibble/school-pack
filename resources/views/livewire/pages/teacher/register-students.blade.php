<div>
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

    <x-responsive-table class="table-bordered">
      <x-slot name="head">
        <x-table.heading>S/N</x-table.heading>
        <x-table.heading sortable wire:click="sortBy('name')" :direction="$sorts['name'] ?? null">Name
        </x-table.heading>
        <x-table.heading></x-table.heading>
      </x-slot>

      <x-slot name="body">
        @forelse($subjects as $subject)
          <x-table.row>
            <x-table.cell>{{ $loop->iteration }}</x-table.cell>
            <x-table.cell>{{ $subject->name }}</x-table.cell>
            <x-table.cell>
              <x-button class="px-0" value="" wire:click="registerStudents({{ $subject->id }})" data-bs-toggle="modal"
                        data-bs-target="#registerStudentModal">
                <i class="bx bxs-plus-circle"></i>
              </x-button>
              {{--                <x-button class="px-0" value="" wire:click="editRegisteredStudents({{ $subject->id }})"--}}
              {{--                          data-bs-toggle="modal"--}}
              {{--                          data-bs-target="#registerStudentModal">--}}
              {{--                  <i class="bx bxs-pen"></i>--}}
              {{--                </x-button>--}}
            </x-table.cell>
          </x-table.row>
        @empty
          <x-table.row>
            <x-table.cell colspan="3" align="center">No record found</x-table.cell>
          </x-table.row>
        @endforelse
      </x-slot>
    </x-responsive-table>
  </x-card>

  <x-modal id="registerStudentModal">
    <x-slot name="title">Register Students for {{ $subject_name }}</x-slot>

    <x-slot name="content">
      <form>
        <x-checked-label for="checkAll" class="mb-2 fw-bolder text-dark">
          <x-checked-input type="checkbox" id="checkAll" wire:model="selectAll" />
          Check All
        </x-checked-label>

        <div class="row">
          {{-- <x-validation-errors /> --}}

          @foreach($students as $student)
            <div class="col-md-6 mb-2">
              <x-checked-label for="student_{{ $student->id }}">
                <x-checked-input type="checkbox" value="{{ $student->id }}" wire:model="fullname"
                                 id="student_{{ $student->id }}" />
                {{ $student->fullname }}
              </x-checked-label>
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

  <x-spinner />
</div>
