<x-app-layout>
    <x-breadcrumb>{{ $class->name . ' ' . $section->name }} Students</x-breadcrumb>
    <x-flash />

    <x-card>
        <div class="d-flex align-items-center">
            <h4 class="my-1">{{ $class->name . ' ' . $section->name }}</h4>

            {{-- <div class="ms-auto d-flex justify-content-end">
              <x-button data-bs-toggle="modal" data-bs-target="#classModal">Add New Class</x-button>
            </div> --}}
        </div>
    </x-card>

    <livewire:pages.teacher.register-students :id="[$class->id, $section->id]" />
    <livewire:pages.teacher.student :id="$section->id" />
</x-app-layout>
