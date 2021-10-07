<div>
  <x-flash />

  <x-card>
    <div class="row">
      <div class="col-md-3">
        <p>Principal's Comment</p>
      </div>

      <div class="col-md-9">
        <x-textarea wire:model.defer="principals_comment" placeholder="Type comment"></x-textarea>
        <x-input-error for="principals_comment" />
      </div>
    </div>

    <x-button wire:click.prevent="store" class="float-end mt-4">Submit Comment</x-button>
  </x-card>
</div>
