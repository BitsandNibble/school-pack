<div>
    <x-breadcrumb>
        Results
        <li class="breadcrumb-item active" aria-current="page">Mark Sheet</li>
        <li class="breadcrumb-item active" aria-current="page">Select Year</li>
    </x-breadcrumb>

    <x-card>
        <div class="row">
            <div class="col-md-6">
                <x-label for="session" class="fw-bolder">Select Session</x-label>
                <x-select id="session" class="mb-2" wire:model="session">
                    @foreach($sessions as $sess)
                        <option value="{{ $sess->year }}" selected>{{ $sess->year }}</option>
                    @endforeach
                </x-select>
                <x-input-error class="mb-2" for="year" />
            </div>

            <div class="col-md-6">
                <x-label for="term" class="fw-bolder">Select Term</x-label>
                <x-select id="term" class="mb-2" wire:model="term">
                    @if(count($terms) > 0)
                        @foreach($terms->where('year', $session)->unique('term') as $t)
                            <option value="{{ $t->term->id }}" selected>{{ $t->term->name }}</option>
                        @endforeach
                    @endif
                </x-select>
                <x-input-error class="mb-2" for="term" />
            </div>

            <div class="d-grid gap-2">
                <x-button wire:click.prevent="submit">Submit</x-button>
            </div>
        </div>
    </x-card>

    <x-spinner />
</div>