<div>
  <x-card>
    <div class="row mb-3">
      <div class="col-sm-3">
        <h6>Old Password</h6>
      </div>
      <div class="col-sm-9 text-secondary">
        <x-input type="password" wire:model.defer="principal.current_password"></x-input>
        <x-input-error for="principal.current_password"></x-input-error>
      </div>
    </div>
    <div class="row mb-3">
      <div class="col-sm-3">
        <h6>New Password</h6>
      </div>
      <div class="col-sm-9 text-secondary">
        <x-input type="password" wire:model.defer="principal.password"></x-input>
        <x-input-error for="principal.password"></x-input-error>
      </div>
      <span></span>
    </div>
    <div class="row mb-3">
      <div class="col-sm-3">
        <h6>Confirm Password</h6>
      </div>
      <div class="col-sm-9 text-secondary">
        <x-input type="password" wire:model.defer="principal.password_confirmation"></x-input>
        <x-input-error for="principal.password_confirmation"></x-input-error>
      </div>
    </div>
    {{--    <x-button class="float-end px-4" value="submit" wire:click="updatePrincipalPassword">Save</x-button>--}}
  </x-card>
</div>
