<div>
    <x-card>
        <div class="row">
            <div class="col-md-3">
                @auth('teacher')
                    <p>Teacher's Comment</p>
                @else
                    <p>Principal's Comment</p>
                @endauth
            </div>

            <div class="col-md-9">
                <x-input type="text" list="comments" wire:model.defer="comment" />
                <datalist id="comments">
                    @foreach ($comments as $comment)
                        <option value="{{ $comment->description }}" />
                    @endforeach
                </datalist>
                <x-input-error for="comment" />
            </div>
        </div>

        <x-button wire:click.prevent="store" class="float-end mt-4">Submit Comment</x-button>
    </x-card>
</div>
