<div>
  <x-flash />

  <x-card>
    <div class="row">
      <div class="col-md-3">
        @auth('teacher')
          <p>Teacher's Comment</p>
        @endauth

        @auth('principal')
          <p>Principal's Comment</p>
        @endauth
      </div>

      <div class="col-md-9">
        @auth('teacher')
          <x-textarea wire:model.defer="teachers_comment" placeholder="Type comment"></x-textarea>
          <x-input-error for="teachers_comment" />
        @endauth

        @auth('principal')
          <x-textarea wire:model.defer="principals_comment" placeholder="Type comment"></x-textarea>
          <x-input-error for="principals_comment" />
        @endauth
      </div>
    </div>

    <x-button wire:click.prevent="store" class="float-end mt-4">Submit Comment</x-button>
  </x-card>
</div>
