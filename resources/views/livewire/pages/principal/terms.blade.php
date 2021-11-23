<div>
  <x-breadcrumb>
    Grading
    <li class="breadcrumb-item active" aria-current="page">Terms</li>
  </x-breadcrumb>

  <x-card>
    <div class="d-flex align-items-center">
      {{-- <h4 class="my-1">Class</h4> --}}

      <div class="ms-auto d-flex justify-content-end">
        <x-button data-bs-toggle="modal" data-bs-target="#termModal">Add New Term</x-button>
      </div>
    </div>
  </x-card>

  <x-card>
    <x-responsive-table>
      <thead>
        <tr>
          <th>S/N</th>
          <th>Name</th>
          <th>Session</th>
          <th>Status</th>
          <th></th>
        </tr>
      </thead>

      <tbody>
        @forelse($terms as $term)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $term->name }}</td>
            <td>{{ $term->session }}</td>
            <td>{{ $term->locked ? 'Locked' : 'Unlocked' }}</td>
            <td>
              <x-button class="px-0" wire:click="edit({{ $term->id }})" value="" data-bs-toggle="modal"
                        data-bs-target="#termModal">
                <i class="bx bxs-pen"></i>
              </x-button>
              <x-button class="px-0" value="" wire:click="openDeleteModal({{ $term->id }})"
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


  <x-confirmation-modal id="termModal">
    <x-slot name="title">{{ isset($this->term_id) ? 'Edit' : 'Add New' }} Term</x-slot>

    <x-slot name="content">
      <p><span class="text-danger">*</span> fields are required</p>
      <p>You're creating a term for the current session {{ get_setting('current_session') }}</p>

      <div class="row">
        <div class="col-md-12 mb-2">
          <x-label for="name">Name <span class="text-danger">*</span></x-label>
          <x-select id="name" wire:model.defer="name">
            @foreach (get_terms() as $index => $term)
              <option value="{{ $term }}">{{ $term }}</option>
            @endforeach
          </x-select>
          <x-input-error for="name" />
        </div>
      </div>
    </x-slot>

    <x-slot name="footer">
      <x-button value="dark" wire:click="cancel">Close</x-button>
      <x-button value="submit" wire:click.prevent="store">Save</x-button>
    </x-slot>
  </x-confirmation-modal>

  <x-confirmation-modal id="deleteModal">
    <x-slot name="title">Delete Term</x-slot>

    <x-slot name="content">
      Are you sure you want to delete this term?
    </x-slot>

    <x-slot name="footer">
      <x-button value="dark" wire:click="cancel">Cancel</x-button>
      <x-button value="danger" wire:click.prevent="delete({{ $deleting }})">Delete</x-button>
    </x-slot>
  </x-confirmation-modal>

  <x-spinner />
</div>