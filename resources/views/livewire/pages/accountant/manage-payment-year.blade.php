<div>
  <x-breadcrumb>
    Payments
    <li class="breadcrumb-item active" aria-current="page">Manage Payments</li>
  </x-breadcrumb>
  <x-flash />

  <x-card>
    <div class="row d-flex justify-content-center text-center">
      <div class="col-6">
        <x-label for="select_year" class="fw-bolder">Select Exam Year</x-label>
        <x-select id="select_year" class="mb-2" wire:model.defer="exam_year">
          @foreach($years as $year)
            <option value="{{ $year->year }}" selected>{{ $year->year }}</option>
          @endforeach
        </x-select>
        <x-input-error for="exam_year" />

        <x-button class="mt-2" wire:click.prevent="submit">Submit</x-button>
      </div>
    </div>
  </x-card>

  <livewire:pages.accountant.manage-payment />

</div>
