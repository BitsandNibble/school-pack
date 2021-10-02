<div>
  <x-breadcrumb>
    Grading
    <li class="breadcrumb-item active" aria-current="page">Exam</li>
  </x-breadcrumb>
  <x-flash />

  <x-card>
    <div class="row">
      <div class="col-md-4 mb-2">
        <x-label for="exam">Exam</x-label>
        <x-select id="exam" wire:model="exam">
          @foreach($exams as $exam)
            <option value="{{ $exam->id }}">{{ $exam->name }}</option>
          @endforeach
        </x-select>
        <x-input-error for="exam" />
      </div>

      <div class="col-md-4 mb-2">
        <x-label for="class">Class</x-label>
        <x-select id="class" wire:model="class">
          @if(count($classes) > 0)
            @foreach($classes as $class)
              <option value="{{ $class->class_room_id }}">{{ $class->class_room->name }}</option>
            @endforeach
          @endif
        </x-select>
        <x-input-error for="class" />
      </div>

      <div class="col-md-4 mb-2">
        <x-label for="subject">Subject</x-label>
        <x-select id="subject" wire:model="subject">
          @if(count($subjects) > 0)
            @foreach($subjects as $subject)
              <option value="{{ $subject->subject->id }}">{{ $subject->subject->name }}</option>
            @endforeach
          @endif
        </x-select>
        <x-input-error for="subject" />
      </div>

      <div class="d-grid gap-2">
        <x-button wire:click.prevent="manage">Manage Mark</x-button>
      </div>
    </div>
  </x-card>

  <livewire:pages.teacher.marks />

  <x-spinner />
</div>