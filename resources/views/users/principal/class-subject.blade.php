<x-app-layout>
    <x-breadcrumb>
        <a href="{{ route('principal.subjects') }}">Subjects</a>
        <li class="breadcrumb-item active" aria-current="page">Class</li>
    </x-breadcrumb>
    <x-flash />

    <livewire:pages.principal.subject :id="$class->id" />
</x-app-layout>
