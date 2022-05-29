<x-card-with-header>
    <x-slot name="header">
        <h6 class="fw-bold my-auto">Notice Board</h6>
    </x-slot>

    @foreach($notices as $notice)
        <h6 class="fw-bolder">{{ $notice->title }}</h6>
        <p>{{ Str::limit($notice->message, 50) }}</p>
        <h6>Author: {{ $notice->principal->fullname }}</h6>
        <div class="d-flex align-items-center">
            <div class="ms-auto d-flex justify-content-end">
                <a href="{{ route('notice', [$notice->id]) }}">
                    <i class='bx bxs-right-arrow-circle font-22'></i>
                </a>
            </div>
        </div>
        <div class="float-end mb-2">
            <h6>Posted: {{ $notice->created_at?->diffForHumans() ?? 'Unknown' }}</h6>
            <h6>Updated: {{ $notice->updated_at?->diffForHumans() ?? 'Unknown' }}</h6>
        </div>
        <br>
        <br>
        <br>
        <br>
    @endforeach

    {{ $notices->links() }}
</x-card-with-header>