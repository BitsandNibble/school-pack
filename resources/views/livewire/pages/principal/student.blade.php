<div>
    @if ($parent !== 2)
        <h5>{{ $title }}</h5>
    @endif

    @if ($parent === 2)
        <x-card>
            <div class="d-flex align-items-center">
                <h4 class="my-1">{{ $class_name }}</h4>

                <div class="ms-auto d-flex justify-content-end">
                    <x-button data-bs-toggle="modal" data-bs-target="#studentModal2">Add New Student</x-button>
                </div>
            </div>
        </x-card>
    @endif

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
                <x-table.heading sortable wire:click="sortBy('fullname')" :direction="$sorts['fullname'] ?? null">Name
                </x-table.heading>
                <x-table.heading sortable wire:click="sortBy('school_id')" :direction="$sorts['school_id'] ?? null">Adm.
                    No
                </x-table.heading>
                <x-table.heading sortable wire:click="sortBy('gender')" :direction="$sorts['gender'] ?? null">Gender
                </x-table.heading>
                @if (!$class_id)
                    <x-table.heading sortable wire:click="sortBy('class_room_id')"
                                     :direction="$sorts['class_room_id'] ?? null">
                        Class
                    </x-table.heading>
                @else
                    <x-table.heading sortable wire:click="sortBy('section_id')"
                                     :direction="$sorts['section_id'] ?? null">Section
                    </x-table.heading>
                @endif
                @if ($parent === null)
                    <x-table.heading></x-table.heading>
                @endif
            </x-slot>

            <x-slot name="body">
                @if ($selectPage)
                    <x-table.row class="bg-gradient-lush">
                        <x-table.cell colspan="7">
                            @unless($selectAll)
                                <div>
                                    You have selected <strong>{{ $students->count() }}</strong> student(s)
                                    @if ($students->count() !== $students->total())
                                        , do you want to select
                                        all
                                        <strong>{{ $students->total() }}</strong>?
                                        <x-button-link wire:click="selectAll">Select All</x-button-link>
                                    @endif
                                </div>
                            @else
                                You have selected all <strong>{{ $students->total() }}</strong> students.
                            @endunless
                        </x-table.cell>
                    </x-table.row>
                @endif

                @forelse ($students as $student)
                    <x-table.row wire.key="row-{{ $student->id }}">
                        <x-table.cell class="pe-0">
                            <x-checked-input type="checkbox" wire:model="selected" value="{{ $student->id }}" />
                        </x-table.cell>
                        <x-table.cell>{{ $loop->iteration }}</x-table.cell>
                        <x-table.cell>{{ $student->fullname }} </x-table.cell>
                        <x-table.cell>{{ $student->school_id }}</x-table.cell>
                        <x-table.cell>{{ $student->gender }}</x-table.cell>
                        @if (!$class_id)
                            <x-table.cell>{{ $student->class_room->name }} {{ $student->section->name }}</x-table.cell>
                        @else
                            <x-table.cell>{{ $student->section->name }}</x-table.cell>
                        @endif
                        @if ($parent === null)
                            <x-table.cell>
                                <x-button class="px-0" value="" wire:click="$emit('showInfo', {{ $student->id }})"
                                          data-bs-toggle="modal" data-bs-target="#infoModal">
                                    <i class="bx bxs-show"></i>
                                </x-button>
                                <x-button class="px-0" wire:click="$emit('edit', {{ $student->id }})" value=""
                                          data-bs-toggle="modal" data-bs-target="#studentModal">
                                    <i class="bx bxs-pen"></i>
                                </x-button>
                                <x-button class="px-0" value=""
                                          wire:click="$emit('openDeleteModal', {{ $student->id }})"
                                          data-bs-toggle="modal" data-bs-target="#deleteModal">
                                    <i class="bx bxs-trash-alt"></i>
                                </x-button>
                            </x-table.cell>
                        @endif
                    </x-table.row>
                @empty
                    <x-table.row>
                        <x-table.cell colspan="7" class="text-center">No record found</x-table.cell>
                    </x-table.row>
                @endforelse
            </x-slot>
        </x-responsive-table>

        {{ $students->links() }}
    </x-card>

    <x-confirmation-modal id="studentModal2">
        <x-slot name="title">Add New Student</x-slot>

        <x-slot name="content">
            <form>
                <p><span class="text-danger">*</span> fields are required</p>

                <div class="row">
                    {{--          <x-validation-errors />--}}

                    <div class="col-md-6 mb-2">
                        <x-label for="fullname">Full Name <span class="text-danger">*</span></x-label>
                        <x-input type="text" id="fullname" wire:model.defer="student.fullname" />
                        <x-input-error for="student.fullname" />
                    </div>

                    <div class="col-md-6 mb-2">
                        <x-label for="gender">Gender</x-label>
                        <x-select id="gender" wire:model.defer="student.gender">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </x-select>
                    </div>
                </div>
            </form>
        </x-slot>

        <x-slot name="footer">
            <x-button value="dark" wire:click="cancel">Close</x-button>
            <x-button value="submit" wire:click.prevent="store">Save</x-button>
        </x-slot>
    </x-confirmation-modal>

    <x-confirmation-modal id="deleteSelectedModal">
        <x-slot name="title">Delete Teacher</x-slot>

        <x-slot name="content">
            Are you sure you want to delete these teachers? This action is irreversible.
        </x-slot>

        <x-slot name="footer">
            <x-button value="dark" wire:click="cancel">Cancel</x-button>
            <x-button value="danger" wire:click.prevent="deleteSelected">Delete</x-button>
        </x-slot>
    </x-confirmation-modal>

    <x-spinner />
</div>
