<div>
  <x-breadcrumb>Notice Board</x-breadcrumb>

  <x-card>
    <div class="d-flex align-items-center">
      {{-- <h4 class="my-1">Class</h4> --}}

      <div class="ms-auto d-flex justify-content-end">
        <x-button data-bs-toggle="modal" data-bs-target="#noticeModal">Add New Notice</x-button>
      </div>
    </div>
  </x-card>

  <x-card>
    <div class="d-flex align-items-center mb-3">
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
        @if ($selected)
          <x-dropdown class="me-3">
            <x-slot name="title">Bulk Actions</x-slot>

            <li>
              <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#deleteSelectedModal" href="#">
                <i class="bx bxs-trash"></i>
                Delete
              </a>
            </li>
            <li><a class="dropdown-item" href="#">Archive</a></li>
            <li><a class="dropdown-item" href="#">Export</a></li>
            {{-- <x-button value="success" wire:click="exportSelected" class="float-end">Export</x-button> --}}
          </x-dropdown>
        @endif

        <x-input type="search" size="sm" placeholder="Search" wire:model.deboounce.500ms="q" />
      </div>
    </div>

    <x-responsive-table>
      <x-slot name="head">
        <x-table.heading class="pe-0" style="width: 30px">
          <x-checked-input type="checkbox" wire:model="selectPage" />
        </x-table.heading>
        <x-table.heading>S/N</x-table.heading>
        <x-table.heading>Title</x-table.heading>
        <x-table.heading>Message</x-table.heading>
        <x-table.heading>Author</x-table.heading>
        <x-table.heading>Created</x-table.heading>
        <x-table.heading>Updated</x-table.heading>
        <x-table.heading></x-table.heading>
      </x-slot>

      <x-slot name="body">
        @if ($selectPage)
          <x-table.row class="bg-gradient-lush">
            <x-table.cell colspan="8">
              @unless($selectAll)
                <div>
                  You have selected <strong>{{ $notices->count() }}</strong> notice(s)
                  @if ($notices->count() !== $notices->total()), do you want to select
                  all
                  <strong>{{ $notices->total() }}</strong>?
                  <x-button-link wire:click="selectAll">Select All</x-button-link>
                  @endif
                </div>
              @else
                You have selected all <strong>{{ $notices->total() }}</strong> notice.
              @endunless
            </x-table.cell>
          </x-table.row>
        @endif

        @forelse ($notices as $notice)
          <x-table.row wire.key="row-{{ $notice->id }}">
            <x-table.cell class="pe-0">
              <x-checked-input type="checkbox" wire:model="selected" value="{{ $notice->id }}" />
            </x-table.cell>
            <x-table.cell>{{ $loop->iteration }}</x-table.cell>
            <x-table.cell>{{ $notice->title }}</x-table.cell>
            <x-table.cell>{{ Str::limit($notice->message, 30) }}</x-table.cell>
            <x-table.cell>{{ $notice->principal->fullname }}</x-table.cell>
            <x-table.cell>{{ $notice->created_at }}</x-table.cell>
            <x-table.cell>{{ $notice->updated_at }}</x-table.cell>
            <x-table.cell>
              <x-button class="px-0" value="" wire:click="showInfo({{ $notice->id }})"
                        data-bs-toggle="modal" data-bs-target="#infoModal">
                <i class="bx bxs-show"></i>
              </x-button>
              <x-button class="px-0" wire:click="edit({{ $notice->id }})" value="" data-bs-toggle="modal"
                        data-bs-target="#noticeModal">
                <i class="bx bxs-pen"></i>
              </x-button>
              <x-button class="px-0" value="" wire:click="openDeleteModal({{ $notice->id }})"
                        data-bs-toggle="modal" data-bs-target="#deleteModal">
                <i class="bx bxs-trash-alt"></i>
              </x-button>
            </x-table.cell>
          </x-table.row>
        @empty
          <x-table.row>
            <x-table.cell colspan="8" class="text-center">No record found</x-table.cell>
          </x-table.row>
        @endforelse
      </x-slot>
    </x-responsive-table>

    {{ $notices->links() }}

  </x-card>

  <x-modal id="noticeModal">
    <x-slot name="title">{{ isset($this->notice_id) ? 'Edit' : 'Add New' }} Notice</x-slot>

    <x-slot name="content">
      <form>
        <p><span class="text-danger">*</span> fields are required</p>
        <div class="row">
          <div class="col-md-6 mb-2">
            <x-label for="title">Title <span class="text-danger">*</span></x-label>
            <x-input type="text" id="title" wire:model.defer="title" />
            <x-input-error for="title" />
          </div>

          <div class="col-md-6">
            <x-label for="message">Message <span class="text-danger">*</span></x-label>
            <x-textarea id="message" wire:model.defer="message" />
            <x-input-error for="message" />
          </div>
        </div>
      </form>
    </x-slot>

    <x-slot name="footer">
      <x-button value="dark" wire:click="cancel">Close</x-button>
      <x-button value="submit" wire:click.prevent="store">Save</x-button>
    </x-slot>
  </x-modal>

  <x-modal id="infoModal">
    <x-slot name="title">Notice Board</x-slot>

    <x-slot name="content">
      <x-table class="table-borderless table-hover">
        <x-slot name="head"></x-slot>

        <x-slot name="body">
          @if($notice_info)
            @foreach($notice_info as $info)
              <x-table.row>
                <x-table.heading>Title</x-table.heading>
                <x-table.cell>{{ $info->title }}</x-table.cell>
              </x-table.row>
              <x-table.row>
                <x-table.heading>Message</x-table.heading>
                <x-table.cell>{{ $info->message }}</x-table.cell>
              </x-table.row>
              <x-table.row>
                <x-table.heading>Author</x-table.heading>
                <x-table.cell>{{ $info->principal->fullname }}</x-table.cell>
              </x-table.row>
            @endforeach
          @endif
        </x-slot>
      </x-table>
    </x-slot>

    <x-slot name="footer">
      <x-button value="dark" wire:click="cancel">Close</x-button>
    </x-slot>
  </x-modal>

  <x-confirmation-modal id="deleteSelectedModal">
    <x-slot name="title">Delete Notice</x-slot>

    <x-slot name="content">
      Are you sure you want to delete these notices? This action is irreversible.
    </x-slot>

    <x-slot name="footer">
      <x-button value="dark" wire:click="cancel">Cancel</x-button>
      <x-button value="danger" wire:click.prevent="deleteSelected">Delete</x-button>
    </x-slot>
  </x-confirmation-modal>

  <x-confirmation-modal id="deleteModal">
    <x-slot name="title">Delete Notice</x-slot>

    <x-slot name="content">
      Are you sure you want to delete this notice?
    </x-slot>

    <x-slot name="footer">
      <x-button value="dark" wire:click="cancel">Cancel</x-button>
      <x-button value="danger" wire:click.prevent="delete({{ $deleting }})">Delete</x-button>
    </x-slot>
  </x-confirmation-modal>

  <x-spinner />
</div>
