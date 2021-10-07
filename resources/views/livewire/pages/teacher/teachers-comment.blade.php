<div>
  <x-flash />

  <x-card>
    <div class="row">
      <div class="col-md-3">
        <p>Teacher's Comment</p>
      </div>

      <div class="col-md-9">
        <x-textarea wire:model.defer="teachers_comment" placeholder="Type comment"></x-textarea>
        <x-input-error for="teachers_comment" />
      </div>
    </div>

    <x-button wire:click.prevent="store" class="float-end mt-4">Submit Comment</x-button>
  </x-card>
</div>
