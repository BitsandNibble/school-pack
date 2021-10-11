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
            <img src="{{ $accountant->thumbnail }}" alt="Admin"
                 class="rounded-circle p-1 bg-primary" width="110">
          @endif
          <div class="mt-3">
            <h4>{{ $accountant->fullname }}</h4>
            <p class="text-secondary mb-1">Accountant</p>
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
            <x-input type="text" wire:model.defer="accountant.fullname" />
            <x-input-error for="accountant.fullname" />
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-sm-3">
            <h6>Staff ID</h6>
          </div>
          <div class="col-sm-9 text-secondary">
            <x-input type="text" readonly value="{{ $accountant->school_id }}" />
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-sm-3">
            <h6>Address</h6>
          </div>
          <div class="col-sm-9 text-secondary">
            <x-textarea wire:model.defer="accountant.address"></x-textarea>
            <x-input-error for="accountant.address" />
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-sm-3">
            <h6>Email</h6>
          </div>
          <div class="col-sm-9 text-secondary">
            <x-input type="text" wire:model.defer="accountant.email" />
            <x-input-error for="accountant.email" />
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-sm-3">
            <h6>Phone</h6>
          </div>
          <div class="col-sm-9 text-secondary">
            <x-input type="text" wire:model.defer="accountant.phone_number" />
            <x-input-error for="accountant.phone_number" />
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-sm-3">
            <h6>Gender</h6>
          </div>
          <div class="col-sm-9 text-secondary">
            <x-select id="gender" wire:model.defer="accountant.gender">
              <option value="Male">Male</option>
              <option value="Female">Female</option>
              <option value="Other">Other</option>
            </x-select>
            <x-input-error for="accountant.gender" />
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-sm-3">
            <h6>Title</h6>
          </div>
          <div class="col-sm-9 text-secondary">
            <x-select id="title" wire:model.defer="accountant.title">
              <option value="Mr">Mr</option>
              <option value="Mrs">Mrs</option>
              <option value="Ms">Ms</option>
              <option value="Miss">Miss</option>
              <option value="Prof">Prof</option>
              <option value="Asst. Prof">Asst. Prof</option>
              <option value="Dr">Dr</option>
            </x-select>
            <x-input-error for="accountant.title" />
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-sm-3">
            <h6>Date of Birth</h6>
          </div>
          <div class="col-sm-9 text-secondary">
            <x-input type="date" wire:model.defer="accountant.date_of_birth" />
            <x-input-error for="accountant.date_of_birth" />
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-sm-3">
            <h6>Date of Employment</h6>
          </div>
          <div class="col-sm-9 text-secondary">
            <x-input type="text" readonly value="{{ $accountant->date_of_employment ?? '' }}" />
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-sm-3">
            <h6>Nationality</h6>
          </div>
          <div class="col-sm-9 text-secondary">
            <x-select wire:model.defer="accountant.nationality_id">
              @foreach($nationalities as $nationality)
                <option value="{{ $nationality->id }}">{{ $nationality->name }}</option>
              @endforeach
            </x-select>
            <x-input-error for="accountant.nationality_id" />
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-sm-3">
            <h6>State</h6>
          </div>
          <div class="col-sm-9 text-secondary">
            <x-select wire:model="state">
              @foreach($states as $state)
                <option value="{{ $state->id }}">{{ $state->name }}</option>
              @endforeach
            </x-select>
            <x-input-error for="state" />
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-sm-3">
            <h6>LGA</h6>
          </div>
          <div class="col-sm-9 text-secondary">
            <x-select wire:model.defer="lga">
              @foreach($lgas as $lga)
                <option value="{{ $lga->id }}">{{ $lga->name }}</option>
              @endforeach
            </x-select>
            <x-input-error for="lga" />
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