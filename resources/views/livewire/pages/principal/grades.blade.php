<div>
  <x-breadcrumb>
    Grading
    <li class="breadcrumb-item active" aria-current="page">Grades</li>
  </x-breadcrumb>

  <x-card>
    <div class="d-flex align-items-center">
      {{-- <h4 class="my-1">Class</h4> --}}

      <div class="ms-auto d-flex justify-content-end">
        <x-button data-bs-toggle="modal" data-bs-target="#gradeModal">Add New Grade</x-button>
      </div>
    </div>
  </x-card>

  <x-card>
    <x-responsive-table>
      <thead>
        <tr>
          <th>S/N</th>
          <th>Name</th>
          <th>Grade Type</th>
          <th>Range</th>
          <th>Remark</th>
          <th></th>
        </tr>
      </thead>

      <tbody>
        @forelse($grades as $gr)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $gr->name }}</td>
            <td>{{ $gr->class_type->name }}</td>
            <td>{{ $gr->mark_from . ' - ' . $gr->mark_to }}</td>
            <td>{{ $gr->remark }}</td>
            <td>
              <x-button class="px-0" wire:click="edit({{ $gr->id }})" value="" data-bs-toggle="modal"
                        data-bs-target="#gradeModal">
                <i class="bx bxs-pen"></i>
              </x-button>
              <x-button class="px-0" value="" wire:click="openDeleteModal({{ $gr->id }})"
                        data-bs-toggle="modal" data-bs-target="#deleteModal">
                <i class="bx bxs-trash-alt"></i>
              </x-button>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6" class="text-center">No record found</td>
          </tr>
        @endforelse
      </tbody>
    </x-responsive-table>
  </x-card>


  <x-confirmation-modal id="gradeModal">
    <x-slot name="title">{{ isset($this->grade_id) ? 'Edit' : 'Add New' }} Grade</x-slot>

    <x-slot name="content">
      <p><span class="text-danger">*</span> fields are required</p>
      <p>If The grade you are creating applies to all class types select NOT APPLICABLE. Otherwise select the Class
        Type That the grade applies to</p>

      <div class="row">
        {{-- <x-validation-errors /> --}}

        <div class="col-md-6 mb-2">
          <x-label for="grade">Name <span class="text-danger">*</span></x-label>
          <x-input type="text" id="grade" wire:model.defer="grade.name" />
          <x-input-error for="grade.name" />
        </div>

        <div class="col-md-6 mb-2">
          <x-label for="class_type">Grade Type</x-label>
          <x-select id="class_type" wire:model.defer="grade.class_type_id">
            <option value='NULL'>Not Applicable</option>
            @foreach ($class_type as $ct)
              <option value="{{ $ct->id }}">{{ $ct->name }}</option>
            @endforeach
          </x-select>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6 mb-2">
          <x-label for="mark_from">Mark From <span class="text-danger">*</span></x-label>
          <x-input type="number" id="mark_from" wire:model.defer="grade.mark_from" />
          <x-input-error for="grade.mark_from" />
        </div>

        <div class="col-md-6 mb-2">
          <x-label for="mark_to">Mark To <span class="text-danger">*</span></x-label>
          <x-input type="number" id="mark_to" wire:model.defer="grade.mark_to" />
          <x-input-error for="grade.mark_to" />
        </div>
      </div>

      <div class="row">
        <div class="col">
          <x-label for="remark">Remark</x-label>
          <x-select id="remark" wire:model.defer="grade.remark">
            @foreach(\App\Helpers\GR::getRemarks() as $remark)
              <option value="{{ $remark }}">{{ $remark }}</option>
            @endforeach
          </x-select>
        </div>
      </div>
    </x-slot>

    <x-slot name="footer">
      <x-button value="dark" wire:click="cancel">Close</x-button>
      <x-button value="submit" wire:click.prevent="store">Save</x-button>
    </x-slot>
  </x-confirmation-modal>

  <x-confirmation-modal id="deleteModal">
    <x-slot name="title">Delete Grade</x-slot>

    <x-slot name="content">
      Are you sure you want to delete this grade?
    </x-slot>

    <x-slot name="footer">
      <x-button value="dark" wire:click="cancel">Cancel</x-button>
      <x-button value="danger" wire:click.prevent="delete({{ $deleting }})">Delete</x-button>
    </x-slot>
  </x-confirmation-modal>

  <x-spinner />
</div>