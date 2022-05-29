<x-app-layout>
    <x-card-with-header>
        <x-slot name="header">
            <h6 class="fw-bold my-auto">Notice Board</h6>
        </x-slot>

        <h6 class="fw-bolder">{{ $notice->title }}</h6>
        <p>{{ $notice->message }}</p>
        <h6>Author: {{ $notice->principal->fullname }}</h6>
        <div class="float-end mb-2">
            <h6>Posted: {{ $notice->created_at->diffForHumans() }}</h6>
            <h6>Updated: {{ $notice->updated_at->diffForHumans() }}</h6>
        </div>
    </x-card-with-header>
</x-app-layout>