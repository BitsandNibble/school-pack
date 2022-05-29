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
                            <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#deleteSelectedModal"
                               href="#">
                                <i class="bx bxs-trash"></i>
                                Delete
                            </a>
                        </li>
                        <li><a class="dropdown-item" href="#">Archive</a></li>
                        <li><a class="dropdown-item" href="#">Export</a></li>
                        {{-- <x-button value="success" wire:click="exportSelected" class="float-end">Export</x-button> --}}
                    </x-dropdown>
                @endif
            </div>
        </div>

        <x-responsive-table>
            <x-slot name="head">
                <x-table.heading class="pe-0" style="width: 30px">
                    <x-checked-input type="checkbox" wire:model="selectPage" />
                </x-table.heading>
                <x-table.heading>S/N</x-table.heading>
                <x-table.heading>Name</x-table.heading>
                <x-table.heading>Session</x-table.heading>
                <x-table.heading>Status</x-table.heading>
                <x-table.heading></x-table.heading>
            </x-slot>

            <x-slot name="body">
                @if ($selectPage)
                    <x-table.row class="bg-gradient-lush">
                        <x-table.cell colspan="6">
                            @unless($selectAll)
                                <div>
                                    You have selected <strong>{{ $terms->count() }}</strong> term(s)
                                    @if ($terms->count() !== $terms->total())
                                        , do you want to select
                                        all
                                        <strong>{{ $terms->total() }}</strong>?
                                        <x-button-link wire:click="selectAll">Select All</x-button-link>
                                    @endif
                                </div>
                            @else
                                You have selected all <strong>{{ $terms->total() }}</strong> terms.
                            @endunless
                        </x-table.cell>
                    </x-table.row>
                @endif

                @forelse($terms as $term)
                    <x-table.row wire.key="row-{{ $term->id }}">
                        <x-table.cell class="pe-0">
                            <x-checked-input type="checkbox" wire:model="selected" value="{{ $term->id }}" />
                        </x-table.cell>
                        <x-table.cell>{{ $loop->iteration }}</x-table.cell>
                        <x-table.cell>{{ $term->name }}</x-table.cell>
                        <x-table.cell>{{ $term->session }}</x-table.cell>
                        <x-table.cell>{{ $term->locked ? 'Locked' : 'Unlocked' }}</x-table.cell>
                        <x-table.cell>
                            <x-button class="px-0" wire:click="edit({{ $term->id }})" value="" data-bs-toggle="modal"
                                      data-bs-target="#termModal">
                                <i class="bx bxs-pen"></i>
                            </x-button>
                            <x-button class="px-0" value="" wire:click="openDeleteModal({{ $term->id }})"
                                      data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="bx bxs-trash-alt"></i>
                            </x-button>
                        </x-table.cell>
                    </x-table.row>
                @empty
                    <x-table.row>
                        <x-table.cell colspan="6" class="text-center">No record found</x-table.cell>
                    </x-table.row>
                @endforelse
            </x-slot>
        </x-responsive-table>

        {{ $terms->links() }}
    </x-card>


    <x-confirmation-modal id="termModal">
        <x-slot name="title">{{ isset($this->term_id) ? 'Edit' : 'Add New' }} Term</x-slot>

        <x-slot name="content">
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

    <x-confirmation-modal id="deleteSelectedModal">
        <x-slot name="title">Delete Terms</x-slot>

        <x-slot name="content">
            Are you sure you want to delete these terms? This action is irreversible.
        </x-slot>

        <x-slot name="footer">
            <x-button value="dark" wire:click="cancel">Cancel</x-button>
            <x-button value="danger" wire:click.prevent="deleteSelected">Delete</x-button>
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