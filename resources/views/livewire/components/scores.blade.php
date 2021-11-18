<div>
  <x-breadcrumb>
    Grading
    <li class="breadcrumb-item active" aria-current="page">Scores</li>
  </x-breadcrumb>

  <x-card>
    <div class="row">
      <div class="col-md-4 mb-2">
        <x-label for="exam">Exam</x-label>
        <x-select id="exam" wire:model="exam_id">
          @foreach($exams as $exam)
            <option value="{{ $exam->id }}">{{ $exam->name }} ({{ $exam->session }})</option>
          @endforeach
        </x-select>
        <x-input-error for="exam_id" />
      </div>

      <div class="col-md-4 mb-2">
        <x-label for="class">Class</x-label>
        <x-select id="class" wire:model="class_id">
          @if(count($classes) > 0)
            @foreach($classes as $class)
              @auth('principal')
                <option value="{{ $class->id }}">{{ $class->name }}</option>
              @endauth

              @auth('teacher')
                <option value="{{ $class->class_room_id }}">{{ $class->class_room->name }}</option>
              @endauth
            @endforeach
          @endif
        </x-select>
        <x-input-error for="class_id" />
      </div>

      <div class="col-md-4 mb-2">
        <x-label for="subject">Subject</x-label>
        <x-select id="subject" wire:model.defer="subject_id">
          @if(count($subjects) > 0)
            @foreach($subjects as $subject)
              <option value="{{ $subject->subject->id }}">{{ $subject->subject->name }}</option>
            @endforeach
          @endif
        </x-select>
        <x-input-error for="subject_id" />
      </div>

      <div class="d-grid gap-2">
        <x-button wire:click.prevent="manage">Manage Mark</x-button>
      </div>
    </div>
  </x-card>

  <livewire:components.scoresheet />

  <x-spinner />
</div>