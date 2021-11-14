<div>
  <x-breadcrumb>
    Payments
    <li class="breadcrumb-item active" aria-current="page">Create Payment</li>
  </x-breadcrumb>

  <x-card-with-header>
    <x-slot name="header">
      <h6 class="fw-bold my-auto">Create Payment</h6>
    </x-slot>

    {{--    <div class="row">--}}
    <div class="col-md-6 mb-2">
      <x-label>Title <span class="text-danger">*</span></x-label>
      <x-input type="text" wire:model.defer="payment.title" placeholder="E.g School Fees" />
      <x-input-error for="payment.title" />
    </div>

    <div class="col-md-6 mb-2">
      <x-label>Class</x-label>
      <x-select wire:model.defer="payment.class">
        <option selected value="NULL">ALL CLASSES</option>
        @foreach($classes as $class)
          <option value="{{ $class->id }}">{{ $class->name }}</option>
        @endforeach
      </x-select>
    </div>

    <div class="col-md-6 mb-2">
      <x-label>Payment Method</x-label>
      <x-select wire:model.defer="payment.method">
        <option value="cash" selected>Cash</option>
        <option value="online" disabled>Online</option>
      </x-select>
    </div>

    <div class="col-md-6 mb-2">
      <x-label>Amount(N) <span class="text-danger">*</span></x-label>
      <x-input type="text" wire:model.defer="payment.amount" />
      <x-input-error for="payment.amount" />
    </div>

    <div class="col-md-6 mb-2">
      <x-label>Description</x-label>
      <x-textarea placeholder="" wire:model.defer="payment.description"></x-textarea>
      <x-input-error for="payment.description" />
    </div>

    <div class="col-md-6 mb-2">
      <x-button class="float-end" value="submit" wire:click.prevent="store">Submit</x-button>
    </div>
    {{--    </div>--}}
  </x-card-with-header>

</div>