<div>
  <x-breadcrumb>
    Grading
    <li class="breadcrumb-item active" aria-current="page">Exam</li>
  </x-breadcrumb>

  <x-card>
    <div class="d-flex align-items-center">
      {{-- <h4 class="my-1">Class</h4> --}}

      <div class="ms-auto d-flex justify-content-end">
        <x-button data-bs-toggle="modal" data-bs-target="#examModal">Add New Exam</x-button>
      </div>
    </div>
  </x-card>

  <x-card>
    <x-responsive-table>
      <thead>
        <tr>
          <th>S/N</th>
          <th>Name</th>
          <th>Term</th>
          <th>Session</th>
          <th>Status</th>
          <th></th>
        </tr>
      </thead>

      <tbody>
        @forelse($exams as $exam)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $exam->name }}</td>
            <td>{{ $exam->term }}</td>
            <td>{{ $exam->session }}</td>
            <td>{{ $exam->locked ? 'Locked' : 'Unlocked' }}</td>
            <td>
              <x-button class="px-0" wire:click="edit({{ $exam->id }})" value="" data-bs-toggle="modal"
                        data-bs-target="#examModal">
                <i class="bx bxs-pen"></i>
              </x-button>
              <x-button class="px-0" value="" wire:click="openDeleteModal({{ $exam->id }})"
                        data-bs-toggle="modal" data-bs-target="#deleteModal">
                <i class="bx bxs-trash-alt"></i>
              </x-button>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="text-center">No record found</td>
          </tr>
        @endforelse
      </tbody>
    </x-responsive-table>
  </x-card>


  <x-confirmation-modal id="examModal">
    <x-slot name="title">{{ isset($this->exam_id) ? 'Edit' : 'Add New' }} Exam</x-slot>

    <x-slot name="content">
      <p><span class="text-danger">*</span> fields are required</p>
      <p>You're creating an exam for the current session {{ get_setting('current_session') }}</p>

      <div class="row">
        <div class="col-md-6 mb-2">
          <x-label for="exam">Name <span class="text-danger">*</span></x-label>
          <x-input type="text" id="exam" wire:model.defer="exam.name" />
          <x-input-error for="exam.name" />
        </div>

        <div class="col-md-6 mb-2">
          <x-label for="exam.term">Term <span class="text-danger">*</span></x-label>
          <x-select id="exam.term" wire:model.defer="exam.term">
            @foreach (\App\Helpers\GR::getTerms() as $index => $term)
              <option value="{{ $index }}">{{ $term }}</option>
            @endforeach
          </x-select>
          <x-input-error for="exam.term" />
        </div>
      </div>
    </x-slot>

    <x-slot name="footer">
      <x-button value="dark" wire:click="cancel">Close</x-button>
      <x-button value="submit" wire:click.prevent="store">Save</x-button>
    </x-slot>
  </x-confirmation-modal>

  <x-confirmation-modal id="deleteModal">
    <x-slot name="title">Delete Exam</x-slot>

    <x-slot name="content">
      Are you sure you want to delete this exam?
    </x-slot>

    <x-slot name="footer">
      <x-button value="dark" wire:click="cancel">Cancel</x-button>
      <x-button value="danger" wire:click.prevent="delete({{ $deleting }})">Delete</x-button>
    </x-slot>
  </x-confirmation-modal>

  <x-spinner />
</div>