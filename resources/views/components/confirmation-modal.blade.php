<div wire:ignore.self class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-hidden="true" {{ $attributes }}>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ $content }}
            </div>
            <div class="modal-footer">
                {{-- <x-button value="dark" data-bs-dismiss="modal">Close</x-button> --}}
                {{ $footer }}
            </div>
        </div>
    </div>
</div>
