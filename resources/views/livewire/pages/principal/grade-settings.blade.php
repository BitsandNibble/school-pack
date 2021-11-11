<div>
  <x-flash />

  <h5 class="mt-5">Grading Settings</h5>
  <x-card class="border-0 border-dark border-5 border-end">
    <p class="fw-bold">Set the maximum scores</p>
    <div class="row">
      <div class="col-md-4 mb-2">
        <x-label for="ca1">First CA <span class="text-danger">*</span></x-label>
        <x-input type="number" id="ca1" wire:model.defer="settings.ca1" />
        <x-input-error for="settings.ca1" />
      </div>

      <div class="col-md-4 mb-2">
        <x-label for="ca2">Second CA <span class="text-danger">*</span></x-label>
        <x-input type="number" id="ca2" wire:model.defer="settings.ca2" />
        <x-input-error for="settings.ca2" />
      </div>

      <div class="col-md-4 mb-2">
        <x-label for="exam">Exam <span class="text-danger">*</span></x-label>
        <x-input type="number" id="exam" wire:model.defer="settings.exam" />
        <x-input-error for="settings.exam" />
      </div>
    </div>

    <p class="mt-4 fw-bold">Other Settings</p>
    <span class="fw-bold">Lock/Unlock Exams</span>
    @foreach($exams as $exam)
      <div class="row mb-2">
        <div class="col-md-4">
          {{ $loop->iteration. '.' }}
          {{ $exam->name }} ({{ $exam->session }})
        </div>

        <div class="col-md-2">
          <x-button value="" wire:click="unlock({{ $exam->id }})">
            @if ($exam->locked)
              <span class="badge rounded-pill bg-warning text-dark">Locked</span>
            @else
              <span class="badge rounded-pill bg-success">Unlocked</span>
            @endif
          </x-button>
        </div>
      </div>
    @endforeach

    <x-button value="submit" class="float-end px-4" wire:click.prevent="store">Save</x-button>
  </x-card>
</div>