<div>
  <x-breadcrumb>Settings</x-breadcrumb>
  <x-flash />

  <h5 class="mt-5">School Information</h5>

  <x-card>
    <form>
      {{-- <x-validation-errors /> --}}

      <div class="row">
        <div class="col-md-8 mb-2">
          <x-input type="hidden" wire:model="school_id" />
          <x-label for="name">School Name <span class="text-danger">*</span></x-label>
          <x-input type="text" id="name" wire:model.defer="school.name" />
          <x-input-error for="school.name" />
        </div>

        <div class="col-md-8 mb-2">
          <x-label for="address">Address <span class="text-danger">*</span></x-label>
          <x-textarea id="address" wire:model.defer="school.address" placeholder=""></x-textarea>
          <x-input-error for="school.address" />
        </div>
      </div>

      <div class="row">
        <div class="col-md-4 mb-2">
          <x-label for="phone_number1">Phone Number 1 <span class="text-danger">*</span></x-label>
          <x-input type="text" id="phone_number1" wire:model.defer="school.phone_number1" />
          <x-input-error for="school.phone_number1" />
        </div>

        <div class="col-md-4 mb-2">
          <x-label for="phone_number2">Phone Number 2</x-label>
          <x-input type="text" id="phone_number2" wire:model.defer="school.phone_number2" />
          <x-input-error for="school.phone_number2" />
        </div>
      </div>

      <div class="row">
        <div class="col-md-8 mb-2">
          <x-label for="school_logo">School Logo</x-label>
          <x-input type="file" id="school_logo" wire:model.defer="school.school_logo" />
          <x-input-error for="school.school_logo" />
        </div>
      </div>

      <x-button value="submit" class="float-end px-4" wire:click.prevent="store">Save</x-button>
    </form>
  </x-card>
</div>
