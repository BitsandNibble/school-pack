<div>
  <x-breadcrumb>
    Payments
    <li class="breadcrumb-item active" aria-current="page">Manage Payments</li>
  </x-breadcrumb>

  <x-card>
    <div class="row d-flex justify-content-center text-center">
      <div class="col-6">
        <x-label for="select_year" class="fw-bolder">Select Session/Year</x-label>
        <x-select id="select_year" class="mb-2" wire:model.defer="session_year">
          @foreach($years as $year)
            <option value="{{ $year->year }}" selected>{{ $year->year }}</option>
          @endforeach
        </x-select>
        <x-input-error for="session_year" />

        <x-button class="mt-2" wire:click.prevent="submit">Submit</x-button>
      </div>
    </div>
  </x-card>
  <x-spinner />

  <livewire:pages.accountant.manage-payment />

</div>
