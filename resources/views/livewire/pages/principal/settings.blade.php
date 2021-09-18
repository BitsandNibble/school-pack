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
          <x-input type="text" id="name" wire:model.defer="settings.school_name" />
          <x-input-error for="settings.school_name" />
        </div>

        <div class="col-md-8 mb-2">
          <x-label for="address">Address <span class="text-danger">*</span></x-label>
          <x-textarea id="address" wire:model.defer="settings.address" placeholder=""></x-textarea>
          <x-input-error for="settings.address" />
        </div>
      </div>

      <div class="row">
        <div class="col-md-4 mb-2">
          <x-label for="phone">Phone Number <span class="text-danger">*</span></x-label>
          <x-input type="text" id="phone" wire:model.defer="settings.phone" />
          <x-input-error for="settings.phone" />
        </div>

        <div class="col-md-4 mb-2">
          <x-label for="mobile">Mobile Number</x-label>
          <x-input type="text" id="mobile" wire:model.defer="settings.mobile" />
          <x-input-error for="settings.mobile" />
        </div>
      </div>

      <div class="row">
        <div class="col-md-8 mb-2">
          <x-label for="school_logo">School Logo</x-label>
          <x-input type="file" id="school_logo" wire:model.defer="settings.school_logo" />
          <x-input-error for="settings.school_logo" />
        </div>
      </div>

      <x-button value="submit" class="float-end px-4" wire:click.prevent="store">Save</x-button>
    </form>
  </x-card>
</div>
