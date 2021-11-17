<div>
  <x-breadcrumb>
    Payments
    <li class="breadcrumb-item active" aria-current="page">Student Payments</li>
  </x-breadcrumb>

  <x-card>
    <div class="row d-flex justify-content-center text-center">
      <div class="col-6">
        <x-label for="class" class="fw-bolder">Select Class</x-label>
        <x-select id="class" class="mb-2" wire:model.defer="class">
          @foreach($classes as $cl)
            <option value="{{ $cl->id }}" selected>{{ $cl->name }}</option>
          @endforeach
        </x-select>
        <x-input-error for="class" />

        <x-button class="mt-2" wire:click.prevent="submit">Submit</x-button>
      </div>
    </div>
  </x-card>
  <x-spinner />

  <livewire:pages.accountant.student-payment />
</div>
