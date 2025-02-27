<div>
    <x-breadcrumb>
        Students
        <li class="breadcrumb-item active" aria-current="page">Promote Students</li>
    </x-breadcrumb>

    <x-card-with-header>
        <x-slot name="header">
            <h5 class="fw-bold my-auto">Student Promotion From <span class="text-danger">{{ $old_year }}</span> TO
                <span class="text-success">{{ $new_year }}</span> Session</h5>
        </x-slot>

        <div class="row">
            <div class="col-md-3 mb-2">
                <x-label for="class">From Class</x-label>
                <x-select id="class" wire:model="from_class">
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                    @endforeach
                </x-select>
                <x-input-error for="from_class" />
            </div>

            <div class="col-md-3 mb-2">
                <x-label for="section">From Section</x-label>
                <x-select id="section" wire:model="from_section">
                    @if(count($fs) > 0)
                        @foreach($fs as $section)
                            <option value="{{ $section->id }}">{{ $section->name }}</option>
                        @endforeach
                    @endif
                </x-select>
                <x-input-error for="from_section" />
            </div>

            <div class="col-md-3 mb-2">
                <x-label for="class">To Class</x-label>
                <x-select id="class" wire:model="to_class">
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                    @endforeach
                </x-select>
                <x-input-error for="to_class" />
            </div>

            <div class="col-md-3 mb-2">
                <x-label for="section">To Section</x-label>
                <x-select id="section" wire:model="to_section">
                    @if(count($ts) > 0)
                        @foreach($ts as $section)
                            <option value="{{ $section->id }}">{{ $section->name }}</option>
                        @endforeach
                    @endif
                </x-select>
                <x-input-error for="to_section" />
            </div>

            <div class="d-grid gap-2">
                <x-button wire:click.prevent="view">View Students</x-button>
            </div>
        </div>
    </x-card-with-header>

    <x-spinner />

    @if($selected)
        <x-card-with-header>
            <x-slot name="header">
                <h5 class="fw-bold my-auto">Promote Students From <span
                            class="text-danger">{{ $class->where('id', $from_class)->first()->name . ' ' . $section->where('id', $from_section)->first()->name }}</span>
                    TO
                    <span
                            class="text-success">{{ $class->where('id', $to_class)->first()->name . ' ' . $section->where('id', $to_section)->first()->name }}</span>
                </h5>
            </x-slot>

            <x-validation-errors />

            <x-responsive-table>
                <x-slot name="head">
                    <x-table.heading>S/N</x-table.heading>
                    <x-table.heading>Name</x-table.heading>
                    <x-table.heading>Current Session</x-table.heading>
                    <x-table.heading></x-table.heading>
                </x-slot>

                <x-slot name="body">
                    @forelse($students as $s)
                        <x-table.row>
                            <x-table.cell>{{ $loop->iteration }}</x-table.cell>
                            <x-table.cell>{{ $s->fullname }}</x-table.cell>
                            <x-table.cell>{{ get_setting('current_session') ?? '' }}</x-table.cell>
                            <x-table.cell>
                                <x-select class="form-select-sm" wire:model.defer="decision">
                                    <option value="P">Promote</option>
                                    <option value="D">Don't Promote</option>
                                    <option value="G">Graduate</option>
                                </x-select>
                            </x-table.cell>
                        </x-table.row>
                    @empty
                        <x-table.row>
                            <x-table.cell colspan="4" class="text-center">No record found</x-table.cell>
                        </x-table.row>
                    @endforelse
                </x-slot>
            </x-responsive-table>

            <div class="d-block mb-2 text-center">
                <x-button wire:click.prevent="promote"><i class="bx bxs-arrow-to-top"></i>Promote Students
                </x-button>
            </div>
        </x-card-with-header>
    @endif
</div>