<div>
  @if($exam_year)
    <x-flash />

    <x-card-with-header>
      <x-slot name="header">
        <h6 class="fw-bold my-auto">Manage Payments for {{ $exam_year }}</h6>
      </x-slot>

      <div class="table-responsive">
        <table class="table table-striped table-sm" style="width:100%">
          <thead>
            <tr>
              <th>S/N</th>
              <th>Title</th>
              <th>Amount</th>
              <th>Ref_No</th>
              <th>Class</th>
              <th>Method</th>
              <th>Description</th>
              <th></th>
            </tr>
          </thead>

          <tbody>
            @forelse($payments as $payment)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $payment->title ?? '' }}</td>
                <td>{{ $payment->amount ?? '' }}</td>
                <td>{{ $payment->ref_no ?? '' }}</td>
                <td>{{ $payment->class_room->name ?? '' }}</td>
                <td>{{ $payment->method ?? '' }}</td>
                <td>{{ $payment->description ?? '' }}</td>
                <td></td>
                  <x-button class="px-0" value="" wire:click="openDeleteModal({{ $payment->id }})"
                            data-bs-toggle="modal" data-bs-target="#deleteModal">
                    <i class="bx bxs-trash-alt"></i>
                  </x-button>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="8" align="center">No record found</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </x-card-with-header>

    <x-confirmation-modal id="deleteModal">
      <x-slot name="title">Delete Payment</x-slot>

      <x-slot name="content">
        Are you sure you want to delete this payment?
      </x-slot>

      <x-slot name="footer">
        <x-button value="dark" wire:click="cancel">Cancel</x-button>
        <x-button value="danger" wire:click.prevent="delete({{ $deleting }})">Delete</x-button>
      </x-slot>
    </x-confirmation-modal>

    <x-spinner />
  @endif
</div>
