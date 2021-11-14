<div>
  <x-breadcrumb>
    Payments
    <li class="breadcrumb-item active" aria-current="page">Student Payments</li>
  </x-breadcrumb>

  <x-card>
    <div class="row d-flex justify-content-center text-center">
      <div class="col-6">
        <x-label for="select_year" class="fw-bolder">Select Class</x-label>
        <x-select id="select_year" class="mb-2" wire:model.defer="class">
          @foreach($classes as $cl)
            <option value="{{ $cl->id }}" selected>{{ $cl->name }}</option>
          @endforeach
        </x-select>
        <x-input-error for="class" />

        <x-button class="mt-2" wire:click.prevent="submit">Submit</x-button>
      </div>
    </div>
  </x-card>

  <livewire:pages.accountant.student-payment />

</div>
