<x-app-layout>
    <x-breadcrumb>
        <a href="{{ route('principal.classes') }}">Classes</a>
        <li class="breadcrumb-item active" aria-current="page">
            <a href="{{ route('principal.sections') }}">Section</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Students</li>
    </x-breadcrumb>

    <livewire:pages.principal.student :id="[$class->id, $section->id]" :type="2" />
</x-app-layout>
