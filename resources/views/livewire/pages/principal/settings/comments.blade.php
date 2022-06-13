<div>
    <x-breadcrumb>
        Settings
        <li class="breadcrumb-item active" aria-current="page">Comments</li>
    </x-breadcrumb>

    <x-card>
        <div class="d-flex align-items-center">
            <div class="ms-auto d-flex justify-content-end">
                <x-button data-bs-toggle="modal" data-bs-target="#commentModal">Add New Comment</x-button>
            </div>
        </div>
    </x-card>

    <x-card>
        <div class="d-flex align-items-center mb-3">
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

                <x-input type="search" size="sm" placeholder="Search" wire:model.deboounce.500ms="q" />
            </div>
        </div>

        <x-responsive-table>
            <x-slot name="head">
                <x-table.heading class="pe-0" style="width: 30px">
                    <x-checked-input type="checkbox" wire:model="selectPage" />
                </x-table.heading>
                <x-table.heading>S/N</x-table.heading>
                <x-table.heading>Description</x-table.heading>
                <x-table.heading></x-table.heading>
            </x-slot>

            <x-slot name="body">
                @if ($selectPage)
                    <x-table.row class="bg-gradient-lush">
                        <x-table.cell colspan="4">
                            @unless($selectAll)
                                <div>
                                    You have selected <strong>{{ $comments->count() }}</strong> comments
                                    @if ($comments->count() !== $comments->total())
                                        , do you want to select all
                                        <strong>{{ $comments->total() }}</strong>?
                                        <x-button-link wire:click="selectAll">Select All</x-button-link>
                                    @endif
                                </div>
                            @else
                                You have selected all <strong>{{ $comments->total() }}</strong> comments.
                            @endunless
                        </x-table.cell>
                    </x-table.row>
                @endif

                @forelse ($comments as $comment)
                    <x-table.row wire.key="row-{{ $comment->id }}">
                        <x-table.cell class="pe-0">
                            <x-checked-input type="checkbox" wire:model="selected" value="{{ $comment->id }}" />
                        </x-table.cell>
                        <x-table.cell>{{ $loop->iteration }}</x-table.cell>
                        <x-table.cell>{{ $comment->description }}</x-table.cell>
                        <x-table.cell>
                            <x-button class="px-0" wire:click="edit({{ $comment->id }})" value=""
                                data-bs-toggle="modal" data-bs-target="#commentModal">
                                <i class="bx bxs-pen"></i>
                            </x-button>
                            <x-button class="px-0" value="" wire:click="openDeleteModal({{ $comment->id }})"
                                data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="bx bxs-trash-alt"></i>
                            </x-button>
                        </x-table.cell>
                    </x-table.row>
                @empty
                    <x-table.row>
                        <x-table.cell colspan="3" align="center">No record found</x-table.cell>
                    </x-table.row>
                @endforelse
            </x-slot>
        </x-responsive-table>

        {{ $comments->links() }}
    </x-card>

    <x-confirmation-modal id="commentModal">
        <x-slot name="title">{{ isset($this->comment_id) ? 'Edit' : 'Add New' }} Comment</x-slot>

        <x-slot name="content">
            @foreach ($descriptions as $key => $value)
                <div class="row" wire:key="description-{{ $key }}">
                    <div class="col mb-2">
                        <x-label for="description">Comment</x-label>
                        <div class="input-group">
                            <x-input type="text" id="description"
                                wire:model.defer="descriptions.{{ $key }}.description" />
                            @unless($this->comment_id)
                                @if ($loop->index === 0)
                                    <x-button wire:click="addInput"><i class="bx bx-plus"></i></x-button>
                                @else
                                    <x-button value="danger" wire:click.prevent="removeInput({{ $key }})">
                                        <i class="bx bx-minus"></i>
                                    </x-button>
                                @endif
                            @endunless
                        </div>
                        <x-input-error for="descriptions.{{ $key }}.description" />
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
        <x-slot name="title">Delete Comments</x-slot>

        <x-slot name="content">
            Are you sure you want to delete these comments? This action is irreversible.
        </x-slot>

        <x-slot name="footer">
            <x-button value="dark" wire:click="cancel">Cancel</x-button>
            <x-button value="danger" wire:click.prevent="deleteSelected">Delete</x-button>
        </x-slot>
    </x-confirmation-modal>

    <x-confirmation-modal id="deleteModal">
        <x-slot name="title">Delete Comment</x-slot>

        <x-slot name="content">
            Are you sure you want to delete this comment?
        </x-slot>

        <x-slot name="footer">
            <x-button value="dark" wire:click="cancel">Cancel</x-button>
            <x-button value="danger" wire:click.prevent="delete({{ $deleting }})">Delete</x-button>
        </x-slot>
    </x-confirmation-modal>

    <x-spinner />
</div>
