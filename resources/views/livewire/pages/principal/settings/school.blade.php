<div>
    <x-breadcrumb>
        Settings
        <li class="breadcrumb-item active" aria-current="page">School</li>
    </x-breadcrumb>

    <h5 class="mt-5">School Information</h5>
    <x-card class="border-0 border-dark border-5 border-end">
        @if($school_logo)
            Logo Preview:
            <img src="{{$school_logo->temporaryUrl()}}" class="mb-2 img-fluid w-50 mx-auto d-block rounded-circle p-1"
                 alt="Preview">
        @else
            <img src="{{ get_school_logo() }}" class="mb-2 img-fluid w-50 mx-auto d-block rounded-circle p-1"
                 alt="School Logo">
        @endif

        <div class="row">
            <div class="col-md-6 mb-2">
                <x-label for="name">School Name <span class="text-danger">*</span></x-label>
                <x-input type="text" id="name" wire:model.defer="settings.school_name" />
                <x-input-error for="settings.school_name" />
            </div>

            <div class="col-md-6 mb-2">
                <x-label for="title">School Title <span class="text-danger">*</span></x-label>
                <x-input type="text" id="title" wire:model.defer="settings.school_title" />
                <x-input-error for="settings.school_title" />
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-2">
                <x-label for="session">Current Session <span class="text-danger">*</span></x-label>
                <div class="d-flex justify-content-between">
                    <div class="col-5 mb-2">
                        <x-select id="session" wire:model.defer="year.0">
                            @for($i = 1; $i <= 5; $i++)
                                <option value="{{ $date1_value++ }}">{{ $date1++ }}</option>
                            @endfor
                        </x-select>
                        <x-input-error for="year.0" />
                    </div>
                    <div class="d-flex">
                        <span class="align-self-center">➡️</span>
                    </div>
                    <div class="col-5 mb-2">
                        <x-select id="session" wire:model.defer="year.1">
                            @for($i = 1; $i <= 5; $i++)
                                <option value="{{ ++$date2_value }}">{{ ++$date2 }}</option>
                            @endfor
                        </x-select>
                        <x-input-error for="year.1" />
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-2">
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <x-label for="term_begins">Term Begins <span class="text-danger">*</span></x-label>
                        <x-input type="date" min="{{ Date('Y-m-d') }}" id="term_begins"
                                 wire:model.defer="settings.term_begins" />
                        <x-input-error for="settings.term_begins" />
                    </div>
                    <div class="col-md-6 mb-2">
                        <x-label for="term_begins">Term Ends <span class="text-danger">*</span></x-label>
                        <x-input type="date" min="{{ Date('Y-m-d') }}" id="term_ends"
                                 wire:model.defer="settings.term_ends" />
                        <x-input-error for="settings.term_ends" />
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-2">
                <x-label for="address">Address <span class="text-danger">*</span></x-label>
                <x-textarea id="address" wire:model.defer="settings.address" placeholder=""></x-textarea>
                <x-input-error for="settings.address" />
            </div>

            <div class="col-md-6 mb-2">
                <x-label for="email">School Mail</x-label>
                <x-input type="text" id="email" wire:model.defer="settings.school_mail" />
                <x-input-error for="settings.school_mail" />
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-2">
                <x-label for="alt_email">Alternative School Mail</x-label>
                <x-input type="text" id="alt_email" wire:model.defer="settings.alt_mail" />
                <x-input-error for="settings.alt_mail" />
            </div>

            <div class="col-md-6 mb-2">
                <x-label for="phone">Phone Number <span class="text-danger">*</span></x-label>
                <x-input type="text" id="phone" wire:model.defer="settings.phone" />
                <x-input-error for="settings.phone" />
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-2">
                <x-label for="mobile">Mobile Number</x-label>
                <x-input type="text" id="mobile" wire:model.defer="settings.mobile" />
                <x-input-error for="settings.mobile" />
            </div>

            <div class="col-md-6 mb-2">
                <x-label for="school_logo">School Logo</x-label>
                <x-input type="file" id="school_logo" wire:model.defer="school_logo" />
                <x-input-error for="school_logo" />
            </div>
        </div>

        <x-button value="submit" class="float-end px-4" wire:click.prevent="store">Save</x-button>
    </x-card>

    <x-spinner />

    <livewire:pages.principal.settings.grading />
    <livewire:pages.principal.settings.others />
</div>
