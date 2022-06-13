<div>
    <x-card>
        <x-validation-errors />

        <div class="row mb-3">
            <div class="col-sm-3">
                <h6>Old Password</h6>
            </div>
            <div class="col-sm-9 text-secondary">
                <x-input type="password" wire:model.defer="current_password"></x-input>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-3">
                <h6>New Password</h6>
            </div>
            <div class="col-sm-9 text-secondary">
                <x-input type="password" wire:model.defer="password"></x-input>
            </div>
            <span></span>
        </div>
        <div class="row mb-3">
            <div class="col-sm-3">
                <h6>Confirm Password</h6>
            </div>
            <div class="col-sm-9 text-secondary">
                <x-input type="password" wire:model.defer="password_confirmation"></x-input>
            </div>
        </div>
        <x-button class="float-end px-4" value="submit" wire:click="updatePassword">Save</x-button>
    </x-card>
</div>
