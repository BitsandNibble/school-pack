<div>
  <x-card>
    <div class="table-responsive">
      <table id="studentsTable" class="table table-striped table-bordered" style="width:100%">
        <thead>
          <tr>
            <th>S/N</th>
            <th>Full name</th>
            <th>Admission no</th>
            <th>Gender</th>
            @if (!$class_id)
              <th>Class</th>
            @endif
            <th></th>
          </tr>
        </thead>

        <tbody>
          @foreach ($students as $student)
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
              <td>
                <x-button class="px-0" value="" wire:click="showInfo({{ $student->id }})"
                  data-bs-toggle="modal" data-bs-target="#infoModal">
                  <i class="bx bxs-show"></i>
                </x-button>
                <x-button class="px-0" wire:click="edit({{ $student->id }})" value="" data-bs-toggle="modal"
                  data-bs-target="#studentModal">
                  <i class="bx bxs-pen"></i>
                </x-button>
                <x-button class="px-0" value="" wire:click="openDeleteModal({{ $student->id }})"
                  data-bs-toggle="modal" data-bs-target="#deleteModal">
                  <i class="bx bxs-trash-alt"></i>
                </x-button>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    {{ $students->links() }}
  </x-card>
</div>
