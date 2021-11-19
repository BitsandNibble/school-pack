<div>
  <x-breadcrumb>
    Results
    <li class="breadcrumb-item active" aria-current="page">Mark Sheet</li>
    <li class="breadcrumb-item active" aria-current="page">Select Year</li>
  </x-breadcrumb>

  <x-card>
    <div class="row d-flex justify-content-center text-center">
      <div class="col-6">

        <x-label for="year" class="fw-bolder">Select Exam Year</x-label>
        <x-select id="year" class="mb-2" wire:model.defer="year">
          @foreach($years as $y)
            <option value="{{ $y->year }}" selected>{{ $y->year }}</option>
          @endforeach
        </x-select>
        <x-input-error class="mb-2" for="year" />

        <x-button wire:click.prevent="submit">Submit</x-button>
      </div>
    </div>
  </x-card>
</div>