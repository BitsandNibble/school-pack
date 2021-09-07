<div>
  <x-breadcrumb>Subjects</x-breadcrumb>
  <x-flash />

  <x-card>
    <div class="d-flex align-items-center">
      {{-- <h4 class="my-1">Class</h4> --}}

      <div class="ms-auto d-flex justify-content-end">
        <x-button data-bs-toggle="modal" data-bs-target="#subjectModal">Add New Subject</x-button>
      </div>
    </div>
  </x-card>
  <h5>All Subjects</h5>

  <h5>Classes</h5>
  <x-card>
    <div class="row pricing-table">
      @foreach ($classes as $class)
        <div class="col-md-4 col-sm-6">
          <x-card>
            <div class="d-flex align-items-center">
              <a class="stretched-link" href="{{ route('principal.classes.subjects', [$class]) }}"></a>
              <h4 class="text-uppercase">{{ $class->name }}</h4>
              <div class="ms-auto d-flex justify-content-end">
                <i class='bx bxs-right-arrow-circle font-22'></i>
              </div>
            </div>
          </x-card>
        </div>
      @endforeach
    </div>
  </x-card>

  <x-card>
    <div class="d-flex align-items-center">
      <div class="d-flex justify-content-start">
        Show <span>&nbsp;</span>
        <select class="form-select form-select-sm" wire:model="paginate">
          <option value="25" selected>25</option>
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
            <th>Name</th>
            <th></th>
          </tr>
        </thead>

        <tbody>
          @forelse ($subjects as $subject)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $subject->name }}</td>
              <td>
                <x-button class="px-0" value="" wire:click="showInfo({{ $subject->id }})"
                          data-bs-toggle="modal" data-bs-target="#infoModal">
                  <i class="bx bxs-show"></i>
                </x-button>
                <x-button class="px-0" wire:click="edit({{ $subject->id }})" value="" data-bs-toggle="modal"
                          data-bs-target="#subjectModal">
                  <i class="bx bxs-pen"></i>
                </x-button>
                <x-button class="px-0" value="" wire:click="openDeleteModal({{ $subject->id }})"
                          data-bs-toggle="modal" data-bs-target="#deleteModal">
                  <i class="bx bxs-trash-alt"></i>
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

      {{ $subjects->links() }}
    </div>
  </x-card>

  <x-confirmation-modal id="subjectModal">
    <x-slot name="title">{{ isset($this->subject_id) ? 'Edit' : 'Add New' }} Subject</x-slot>

    <x-slot name="content">
      <form>
        <div class="row">
          {{-- <x-validation-errors /> --}}

          <div class="col mb-2">
            <x-label for="name">Subject</x-label>
            <x-input type="text" id="name" wire:model.defer="name" />
            <x-input-error for="name" />
          </div>
        </div>
      </form>
    </x-slot>

    <x-slot name="footer">
      <x-button value="dark" wire:click="cancel">Close</x-button>
      <x-button value="submit" wire:click.prevent="store">Save</x-button>
    </x-slot>
  </x-confirmation-modal>

  <x-confirmation-modal id="deleteModal">
    <x-slot name="title">Delete Subject</x-slot>

    <x-slot name="content">
      Are you sure you want to delete this subject?
    </x-slot>

    <x-slot name="footer">
      <x-button value="dark" wire:click="cancel">Cancel</x-button>
      <x-button value="danger" wire:click.prevent="delete({{ $deleting }})">Delete</x-button>
    </x-slot>
  </x-confirmation-modal>
</div>