<div>
  <x-breadcrumb>Profile</x-breadcrumb>
  <x-flash />

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
            <p class="text-muted font-size-sm">Bay Area, San Francisco, CA</p>
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
        <x-button class="float-end px-4" value="submit" wire:click="updatePrincipalProfile">Save</x-button>
      </x-card>

      <livewire:components.update-password />
    </div>
  </div>
</div>
