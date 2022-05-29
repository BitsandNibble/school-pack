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
                            <a class="stretched-link"
                               href="{{ route('principal.classes.subjects', [$class->slug]) }}"></a>
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
                <x-table.heading>Name</x-table.heading>
                <x-table.heading></x-table.heading>
            </x-slot>

            <x-slot name="body">
                @if ($selectPage)
                    <x-table.row class="bg-gradient-lush">
                        <x-table.cell colspan="4">
                            @unless($selectAll)
                                <div>
                                    You have selected <strong>{{ $subjects->count() }}</strong> subjects
                                    @if ($subjects->count() !== $subjects->total())
                                        , do you want to select all
                                        <strong>{{ $subjects->total() }}</strong>?
                                        <x-button-link wire:click="selectAll">Select All</x-button-link>
                                    @endif
                                </div>
                            @else
                                You have selected all <strong>{{ $subjects->total() }}</strong> subjects.
                            @endunless
                        </x-table.cell>
                    </x-table.row>
                @endif

                @forelse ($subjects as $subject)
                    <x-table.row wire.key="row-{{ $subject->id }}">
                        <x-table.cell class="pe-0">
                            <x-checked-input type="checkbox" wire:model="selected" value="{{ $subject->id }}" />
                        </x-table.cell>
                        <x-table.cell>{{ $loop->iteration }}</x-table.cell>
                        <x-table.cell>{{ $subject->name }}</x-table.cell>
                        <x-table.cell>
                            <x-button class="px-0" wire:click="edit({{ $subject->id }})" value="" data-bs-toggle="modal"
                                      data-bs-target="#subjectModal">
                                <i class="bx bxs-pen"></i>
                            </x-button>
                            <x-button class="px-0" value="" wire:click="openDeleteModal({{ $subject->id }})"
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
