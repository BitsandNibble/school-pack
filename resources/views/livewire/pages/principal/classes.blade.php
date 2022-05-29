<div>
    <x-breadcrumb>
        Classes
        <li class="breadcrumb-item active" aria-current="page">Classes</li>
    </x-breadcrumb>

    <x-card>
        <div class="d-flex align-items-center">
            {{-- <h4 class="my-1">Class</h4> --}}

            <div class="ms-auto d-flex justify-content-end">
                <x-button data-bs-toggle="modal" data-bs-target="#classModal">Add New Class</x-button>
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

                <x-input type="search" size="sm" placeholder="Search" wire:model.deboounce.500ms="q" />
            </div>
        </div>

        <x-responsive-table>
            <x-slot name="head">
                <x-table.heading class="pe-0" style="width: 30px">
                    <x-checked-input type="checkbox" wire:model="selectPage" />
                </x-table.heading>
                <x-table.heading>S/N</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('name')" :direction="$sorts['name'] ?? null">Name
                </x-table.heading>
                <x-table.heading sortable wire:click="sortBy('class_type_id')"
                                 :direction="$sorts['class_type_id'] ?? null">
                    Class Type
                </x-table.heading>
                <x-table.heading></x-table.heading>
            </x-slot>

            <x-slot name="body">
                @if ($selectPage)
                    <x-table.row class="bg-gradient-lush">
                        <x-table.cell colspan="5">
                            @unless($selectAll)
                                <div>
                                    You have selected <strong>{{ $classes->count() }}</strong> class(es)
                                    @if ($classes->count() !== $classes->total())
                                        , do you want to select
                                        all
                                        <strong>{{ $classes->total() }}</strong>?
                                        <x-button-link wire:click="selectAll">Select All</x-button-link>
                                    @endif
                                </div>
                            @else
                                You have selected all <strong>{{ $classes->total() }}</strong> classes.
                            @endunless
                        </x-table.cell>
                    </x-table.row>
                @endif

                @forelse($classes as $class)
                    <x-table.row wire.key="row-{{ $class->id }}">
                        <x-table.cell class="pe-0">
                            <x-checked-input type="checkbox" wire:model="selected" value="{{ $class->id }}" />
                        </x-table.cell>
                        <x-table.cell>{{ $loop->iteration }}</x-table.cell>
                        <x-table.cell style="transform: rotate(0);">
                            <a href="{{ route('principal.classes.students', [$class->slug]) }}"
                               class="stretched-link">
                                {{ $class->name }}
                            </a>
                        </x-table.cell>
                        <x-table.cell>{{ $class->class_type->name }}</x-table.cell>
                        <x-table.cell>
                            <x-button class="px-0" wire:click="edit({{ $class->id }})" value="" data-bs-toggle="modal"
                                      data-bs-target="#classModal">
                                <i class="bx bxs-pen"></i>
                            </x-button>
                            <x-button class="px-0" value="" wire:click="openDeleteModal({{ $class->id }})"
                                      data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="bx bxs-trash-alt"></i>
                            </x-button>
                        </x-table.cell>
                    </x-table.row>
                @empty
                    <x-table.row>
                        <x-table.cell colspan="5" align="center">No record found</x-table.cell>
                    </x-table.row>
                @endforelse
            </x-slot>
        </x-responsive-table>

        {{ $classes->links() }}
    </x-card>

    <x-confirmation-modal id="classModal">
        <x-slot name="title">{{ isset($this->class_id) ? 'Edit' : 'Add New' }} Class</x-slot>

        <x-slot name="content">
            <p><span class="text-danger">*</span> fields are required</p>

            <div class="row">
                {{-- <x-validation-errors /> --}}

                <div class="col mb-2">
                    <x-label for="name">Class Name <span class="text-danger">*</span></x-label>
                    <x-input type="text" id="name" wire:model.defer="name" />
                    <x-input-error for="name" />
                </div>

                <div class="col mb-2">
                    <x-label for="class_type">Class Type <span class="text-danger">*</span></x-label>
                    <x-select id="class_type" wire:model.defer="class_type_id">
                        @foreach ($class_types as $class_type)
                            <option value="{{ $class_type->id }}">{{ $class_type->name }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error for="class_type_id" />
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-button value="dark" wire:click="cancel">Close</x-button>
            <x-button value="submit" wire:click.prevent="store">Save</x-button>
        </x-slot>
    </x-confirmation-modal>

    <x-confirmation-modal id="deleteSelectedModal">
        <x-slot name="title">Delete Class</x-slot>

        <x-slot name="content">
            Are you sure you want to delete these classes? This action is irreversible.
        </x-slot>

        <x-slot name="footer">
            <x-button value="dark" wire:click="cancel">Cancel</x-button>
            <x-button value="danger" wire:click.prevent="deleteSelected">Delete</x-button>
        </x-slot>
    </x-confirmation-modal>

    <x-confirmation-modal id="deleteModal">
        <x-slot name="title">Delete Class</x-slot>

        <x-slot name="content">
            Are you sure you want to delete this class?
        </x-slot>

        <x-slot name="footer">
            <x-button value="dark" wire:click="cancel">Cancel</x-button>
            <x-button value="danger" wire:click.prevent="delete({{ $deleting }})">Delete</x-button>
        </x-slot>
    </x-confirmation-modal>

    <x-spinner />
</div>
