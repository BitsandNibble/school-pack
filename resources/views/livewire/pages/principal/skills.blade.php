<div>
    <x-breadcrumb>
        Grading
        <li class="breadcrumb-item active" aria-current="page">Skills</li>
    </x-breadcrumb>

    <x-card>
        <div class="d-flex align-items-center">
            {{-- <h4 class="my-1">Class</h4> --}}

            <div class="ms-auto d-flex justify-content-end">
                <x-button data-bs-toggle="modal" data-bs-target="#skillModal">Add New Skill</x-button>
            </div>
        </div>
    </x-card>

    <x-card>
        <div class="ms-auto d-flex justify-content-end mb-3">
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
        </div>

        <x-responsive-table>
            <x-slot name="head">
                <x-table.heading class="pe-0" style="width: 30px">
                    <x-checked-input type="checkbox" wire:model="selectPage" />
                </x-table.heading>
                <x-table.heading>S/N</x-table.heading>
                <x-table.heading>Name</x-table.heading>
                <x-table.heading>Skill Type</x-table.heading>
                <x-table.heading>Class Type</x-table.heading>
                <x-table.heading></x-table.heading>
            </x-slot>

            <x-slot name="body">
                @if ($selectPage)
                    <x-table.row class="bg-gradient-lush">
                        <x-table.cell colspan="7">
                            @unless($selectAll)
                                <div>
                                    You have selected <strong>{{ $skills->count() }}</strong> skill(s)
                                    @if ($skills->count() !== $total)
                                        , do you want to select
                                        all
                                        <strong>{{ $total }}</strong>?
                                        <x-button-link wire:click="selectAll">Select All</x-button-link>
                                    @endif
                                </div>
                            @else
                                You have selected all <strong>{{ $total }}</strong> skills.
                            @endunless
                        </x-table.cell>
                    </x-table.row>
                @endif

                @forelse($skills as $sk)
                    <x-table.row wire.key="row-{{ $sk->id }}">
                        <x-table.cell class="pe-0">
                            <x-checked-input type="checkbox" wire:model="selected" value="{{ $sk->id }}" />
                        </x-table.cell>
                        <x-table.cell>{{ $loop->iteration }}</x-table.cell>
                        <x-table.cell>{{ $sk->name }}</x-table.cell>
                        <x-table.cell>{{ $sk->skill_type }}</x-table.cell>
                        <x-table.cell>{{ $sk->class_type->name }}</x-table.cell>
                        <x-table.cell>
                            <x-button class="px-0" wire:click="edit({{ $sk->id }})" value="" data-bs-toggle="modal"
                                      data-bs-target="#skillModal">
                                <i class="bx bxs-pen"></i>
                            </x-button>
                            <x-button class="px-0" value="" wire:click="openDeleteModal({{ $sk->id }})"
                                      data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="bx bxs-trash-alt"></i>
                            </x-button>
                        </x-table.cell>
                    </x-table.row>
                @empty
                    <x-table.row>
                        <x-table.cell colspan="7" class="text-center">No record found</x-table.cell>
                    </x-table.row>
                @endforelse
            </x-slot>
        </x-responsive-table>
    </x-card>


    <x-modal id="skillModal">
        <x-slot name="title">{{ isset($this->skill_id) ? 'Edit' : 'Add New' }} Skill</x-slot>

        <x-slot name="content">
            <p><span class="text-danger">*</span> fields are required</p>
            <p>If the skill you are creating applies to all class types select NOT APPLICABLE. Otherwise select the
                Class
                Type That the skill applies to</p>

            <div class="row">
                {{--         <x-validation-errors />--}}

                <div class="col-md-4 mb-2">
                    <x-label for="skill">Name <span class="text-danger">*</span></x-label>
                    <x-input type="text" id="skill" wire:model.defer="skill.name" />
                    <x-input-error for="skill.name" />
                </div>

                <div class="col-md-4 mb-2">
                    <x-label for="skill_type">Skill Type <span class="text-danger">*</span></x-label>
                    <x-select id="skill_type" wire:model.defer="skill.skill_type">
                        <option value="AF">Affective Traits/Skills</option>
                        <option value="PS">Psychomotor Traits/Skills</option>
                    </x-select>
                    <x-input-error for="skill.skill_type" />
                </div>

                <div class="col-md-4 mb-2">
                    <x-label for="class_type">Class Type</x-label>
                    <x-select id="class_type" wire:model.defer="skill.class_type_id">
                        <option value="NULL">Not Applicable</option>
                        @foreach ($class_types as $ct)
                            <option value="{{ $ct->id }}">{{ $ct->name }}</option>
                        @endforeach
                    </x-select>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-button value="dark" wire:click="cancel">Close</x-button>
            <x-button value="submit" wire:click.prevent="store">Save</x-button>
        </x-slot>
    </x-modal>

    <x-confirmation-modal id="deleteSelectedModal">
        <x-slot name="title">Delete Skill</x-slot>

        <x-slot name="content">
            Are you sure you want to delete these skills? This action is irreversible.
        </x-slot>

        <x-slot name="footer">
            <x-button value="dark" wire:click="cancel">Cancel</x-button>
            <x-button value="danger" wire:click.prevent="deleteSelected">Delete</x-button>
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