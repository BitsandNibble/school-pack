<div>
  <x-breadcrumb>Subjects</x-breadcrumb>

  <x-card>
    <div class="d-flex align-items-center">
      {{-- <h4 class="my-1">Class</h4> --}}

      <div class="ms-auto d-flex justify-content-end">
        <x-button data-bs-toggle="modal" data-bs-target="#subjectModal">Add New Subject</x-button>
      </div>
    </div>
  </x-card>

  <h5>Subjects Per Class</h5>
  <x-card>
    <div class="row pricing-table">
      @foreach ($classes as $class)
        <div class="col-md-4 col-sm-6">
          <x-card>
            <div class="d-flex align-items-center">
              <a class="stretched-link" href="{{ route('principal.classes.subjects', [$class->slug]) }}"></a>
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

  <h5>All Subjects</h5>

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

      @if ($selected)
        <div class="ms-auto d-flex justify-content-end">
          <x-button value="danger" class="float-end" data-bs-toggle="modal" data-bs-target="#deleteSelectedModal">
            Delete
          </x-button>
          {{-- <x-button value="success" wire:click="exportSelected" class="float-end">Export</x-button> --}}
        </div>
      @endif
      <div class="ms-auto d-flex justify-content-end">
        <x-input type="search" placeholder="Search" wire:model.deboounce.500ms="q" class="mb-3" />
      </div>
    </div>

    <x-responsive-table>
      <thead>
        <tr>
          <th class="pe-0" style="width: 30px">
            <x-checked-input type="checkbox" wire:model="selectPage" />
          </th>
          <th>S/N</th>
          <th>Name</th>
          <th></th>
        </tr>
      </thead>

      <tbody>
        @if ($selectPage)
          <tr class="bg-gradient-lush">
            <td colspan="4">
              @unless($selectAll)
                <div>
                  You have selected <strong>{{ $subjects->count() }}</strong> subjects, do you want to select all
                  <strong>{{ $subjects->total() }}</strong>?
                  <x-button-link wire:click="selectAll">Select All</x-button-link>
                </div>
              @else
                You have selected all <strong>{{ $subjects->total() }}</strong> subjects.
              @endunless
            </td>
          </tr>
        @endif

        @forelse ($subjects as $subject)
          <tr wire.key="row-{{ $subject->id }}">
            <td class="pe-0">
              <x-checked-input type="checkbox" wire:model="selected" value="{{ $subject->id }}" />
            </td>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $subject->name }}</td>
            <td>
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
    </x-responsive-table>

    {{ $subjects->links() }}
  </x-card>

  <x-confirmation-modal id="subjectModal">
    <x-slot name="title">{{ isset($this->subject_id) ? 'Edit' : 'Add New' }} Subject</x-slot>

    <x-slot name="content">
      @foreach ($names as $key => $value)
        <div class="row" wire:key="name-{{ $key }}">
          <div class="col mb-2">
            <x-label for="name">Subject</x-label>
            <div class="input-group">
              <x-input type="text" id="name" wire:model.defer="names.{{ $key }}.name" />
              @unless($this->subject_id)
                @if ($loop->index === 0)
                  <x-button wire:click="addInput"><i class="bx bx-plus"></i></x-button>
                @else
                  <x-button value="danger" wire:click.prevent="removeInput({{ $key }})">
                    <i class="bx bx-minus"></i>
                  </x-button>
                @endif
              @endunless
            </div>
            <x-input-error for="names.{{ $key }}.name" />
          </div>
        </div>
      @endforeach
    </x-slot>

    <x-slot name="footer">
      <x-button value="dark" wire:click="cancel">Close</x-button>
      <x-button value="submit" wire:click.prevent="store">Save</x-button>
    </x-slot>
  </x-confirmation-modal>

  <x-confirmation-modal id="deleteSelectedModal">
    <x-slot name="title">Delete Subject</x-slot>

    <x-slot name="content">
      Are you sure you want to delete these subjects? This action is irreversible.
    </x-slot>

    <x-slot name="footer">
      <x-button value="dark" wire:click="cancel">Cancel</x-button>
      <x-button value="danger" wire:click.prevent="deleteSelected">Delete</x-button>
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

  <x-spinner />
</div>
