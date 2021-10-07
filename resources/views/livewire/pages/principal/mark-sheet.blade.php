<div>
  <x-breadcrumb>
    Results
    <li class="breadcrumb-item active" aria-current="page">Mark Sheet</li>
  </x-breadcrumb>

  <x-card>
    <div class="row">
      <div class="col-md-4 mb-2">
        <x-label for="class">Class</x-label>
        <x-select id="class" wire:model="class_id">
            @foreach($classes as $class)
              <option value="{{ $class->class_room->id }}">{{ $class->class_room->name }}</option>
            @endforeach
        </x-select>
        <x-input-error for="class_id" />
      </div>

      <div class="col-md-4 mb-2">
        <x-label for="section">Section</x-label>
        <x-select id="section" wire:model.defer="section_id">
          @if(count($sections) > 0)
            @foreach($sections as $section)
              <option value="{{ $section->id }}">{{ $section->name }}</option>
            @endforeach
          @endif
        </x-select>
        <x-input-error for="section_id" />
      </div>

      <div class="d-grid gap-2">
        <x-button wire:click.prevent="view">View Mark Sheet</x-button>
      </div>
    </div>
  </x-card>

  <livewire:pages.teacher.class-marksheet />

  <x-spinner />
</div>