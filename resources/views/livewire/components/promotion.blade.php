<div>
  <x-breadcrumb>
    Students
    <li class="breadcrumb-item active" aria-current="page">Promote Students</li>
  </x-breadcrumb>

  <x-card-with-header>
    <x-slot name="header">
      <h5 class="fw-bold my-auto">Student Promotion From <span class="text-danger">{{ $old_year }}</span> TO
        <span class="text-success">{{ $new_year }}</span> Session</h5>
    </x-slot>

    <div class="row">
      <div class="col-md-3 mb-2">
        <x-label for="class">From Class</x-label>
        <x-select id="class" wire:model="from_class">
          @foreach($classes as $class)
            <option value="{{ $class->id }}">{{ $class->name }}</option>
          @endforeach
        </x-select>
        <x-input-error for="from_class" />
      </div>

      <div class="col-md-3 mb-2">
        <x-label for="section">From Section</x-label>
        <x-select id="section" wire:model="from_section">
          @if(count($fs) > 0)
            @foreach($fs as $section)
              <option value="{{ $section->id }}">{{ $section->name }}</option>
            @endforeach
          @endif
        </x-select>
        <x-input-error for="from_section" />
      </div>

      <div class="col-md-3 mb-2">
        <x-label for="class">To Class</x-label>
        <x-select id="class" wire:model="to_class">
          @foreach($classes as $class)
            <option value="{{ $class->id }}">{{ $class->name }}</option>
          @endforeach
        </x-select>
        <x-input-error for="to_class" />
      </div>

      <div class="col-md-3 mb-2">
        <x-label for="section">To Section</x-label>
        <x-select id="section" wire:model="to_section">
          @if(count($ts) > 0)
            @foreach($ts as $section)
              <option value="{{ $section->id }}">{{ $section->name }}</option>
            @endforeach
          @endif
        </x-select>
        <x-input-error for="to_section" />
      </div>

      <div class="d-grid gap-2">
        <x-button wire:click.prevent="view">Manage Promotion</x-button>
      </div>
    </div>
  </x-card-with-header>

  <livewire:components.promote />

  <x-spinner />
</div>