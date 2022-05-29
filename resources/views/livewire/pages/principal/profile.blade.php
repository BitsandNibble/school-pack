<div>
    <x-breadcrumb>Profile</x-breadcrumb>

    <h5 class="mt-5">Personal Information</h5>

    <div class="row">
        <div class="col-lg-4">
            <x-card>
                <div class="d-flex flex-column align-items-center text-center">
                    @if($profile_photo)
                        Photo Preview:
                        <img src="{{$profile_photo->temporaryUrl()}}" class="rounded-circle p-1 bg-primary" width="110"
                             alt="Preview">
                    @else
                        <img src="{{ $principal->thumbnail }}" alt="Admin"
                             class="rounded-circle p-1 bg-primary" width="110">
                    @endif
                    <div class="mt-3">
                        <h4>{{ $principal->fullname }}</h4>
                        <p class="text-secondary mb-1">Principal</p>
                        <p class="text-muted font-size-sm">{{ $principal->address }}</p>
                    </div>
                </div>
                <hr class="my-4" />
            </x-card>
        </div>
        <div class="col-lg-8">
            <x-card>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6>Full Name</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <x-input type="text" wire:model.defer="principal.fullname" />
                        <x-input-error for="principal.fullname" />
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6>Address</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <x-textarea wire:model.defer="principal.address"></x-textarea>
                        <x-input-error for="principal.address" />
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6>Email</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <x-input type="text" wire:model.defer="principal.email" />
                        <x-input-error for="principal.email" />
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6>Phone</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <x-input type="text" wire:model.defer="principal.phone_number" />
                        <x-input-error for="principal.phone_number" />
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6>Nationality</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <x-select wire:model.defer="principal.nationality_id">
                            @foreach($nationalities as $nationality)
                                <option value="{{ $nationality->id }}">{{ $nationality->name }}</option>
                            @endforeach
                        </x-select>
                        <x-input-error for="principal.nationality_id" />
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6>State</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <x-select wire:model.defer="principal.state_id">
                            @foreach($states as $state)
                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                            @endforeach
                        </x-select>
                        <x-input-error for="principal.state_id" />
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6>LGA</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <x-select wire:model.defer="principal.lga_id">
                            @foreach($lgas as $lga)
                                <option value="{{ $lga->id }}">{{ $lga->name }}</option>
                            @endforeach
                        </x-select>
                        <x-input-error for="principal.lga_id" />
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6>Profile Image</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <x-input type="file" wire:model.defer="profile_photo" />
                        <x-input-error for="profile_photo" />
                    </div>
                </div>
                {{-- <div class="row mb-3">
                  <div class="col-sm-3">
                    <h6 class="mb-0">Address</h6>
                  </div>
                  <div class="col-sm-9 text-secondary">
                    <input type="text" class="form-control" value="Bay Area, San Francisco, CA" />
                  </div>
                </div> --}}
                <x-button class="float-end px-4" value="submit" wire:click="update">Save</x-button>
            </x-card>

            <livewire:components.update-password />
        </div>
    </div>
</div>
