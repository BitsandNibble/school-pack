<div>
  <x-breadcrumb>
    Financials
    <li class="breadcrumb-item active" aria-current="page">Student Payments</li>
  </x-breadcrumb>

  <x-card>
    <div class="row d-flex justify-content-center text-center">
      <div class="col-6">
        <x-label for="session" class="fw-bolder">Select Session</x-label>
        <x-select id="session" class="mb-2" wire:model.defer="session">
          @foreach($sessions as $sess)
            <option value="{{ $sess->session }}" selected>{{ $sess->session }}</option>
          @endforeach
        </x-select>
        <x-input-error for="session" />

        <x-button class="mt-2" wire:click.prevent="submit">Submit</x-button>
      </div>
    </div>
  </x-card>
  <x-spinner />

  @if($session)
    <x-card>
      <ul class="nav nav-tabs nav-primary" role="tablist">
        <li class="nav-item" role="presentation">
          <a class="nav-link active" data-bs-toggle="tab" href="#incomplete" role="tab" aria-selected="true">
            <div class="d-flex align-items-center">
              <div class="tab-title">Incomplete Payments</div>
            </div>
          </a>
        </li>
        <li class="nav-item" role="presentation">
          <a class="nav-link" data-bs-toggle="tab" href="#complete" role="tab" aria-selected="false">
            <div class="d-flex align-items-center">
              <div class="tab-title">Complete Payments</div>
            </div>
          </a>
        </li>
      </ul>

      <div class="tab-content py-3">
        <div class="tab-pane fade active show" id="incomplete" role="tabpanel">
          <x-responsive-table>
            <x-slot name="head">
              <x-table.heading>S/N</x-table.heading>
              <x-table.heading>Title</x-table.heading>
              <x-table.heading>Desc</x-table.heading>
              <x-table.heading>Pay_Ref</x-table.heading>
              <x-table.heading>Amount</x-table.heading>
              <x-table.heading>Paid</x-table.heading>
              <x-table.heading>Balance</x-table.heading>
              <x-table.heading>Receipt_No</x-table.heading>
              <x-table.heading>Session</x-table.heading>
              <x-table.heading>Term</x-table.heading>
              <x-table.heading></x-table.heading>
            </x-slot>

            <x-slot name="body">
              @forelse($uncleared as $index => $uc)
                <x-table.row>
                  <x-table.cell>{{ $loop->iteration }}</x-table.cell>
                  <x-table.cell>{{ $uc->payment->title }}</x-table.cell>
                  <x-table.cell>{{ Str::limit($uc->payment->description, 20) }}</x-table.cell>
                  <x-table.cell>{{ $uc->payment->ref_no }}</x-table.cell>
                  <x-table.cell class="fw-bold text-decoration-underline">{{ $uc->payment->amount }}</x-table.cell>
                  <x-table.cell class="text-info">{{ $uc->amount_paid ?: '0.00' }}</x-table.cell>
                  <x-table.cell class="text-danger">{{ $uc->balance ?: $uc->payment->amount }}</x-table.cell>
                  <x-table.cell>{{ $uc->ref_no }}</x-table.cell>
                  <x-table.cell>{{ $uc->session }}</x-table.cell>
                  <x-table.cell>{{ $uc->payment->term->name }}</x-table.cell>
                  <x-table.cell>
                    <x-button-link target="_blank" href="{{ route('print_invoice', $uc->id) }}" value="">
                      <i class="bx bx-printer"></i>
                    </x-button-link>
                  </x-table.cell>
                </x-table.row>
              @empty
                <x-table.row>
                  <x-table.cell colspan="11" align="center">No record found</x-table.cell>
                </x-table.row>
              @endforelse
            </x-slot>
          </x-responsive-table>
        </div>

        <div class="tab-pane fade" id="complete" role="tabpanel">
          <x-responsive-table>
            <x-slot name="head">
              <x-table.heading>S/N</x-table.heading>
              <x-table.heading>Title</x-table.heading>
              <x-table.heading>Desc</x-table.heading>
              <x-table.heading>Pay_Ref</x-table.heading>
              <x-table.heading>Amount</x-table.heading>
              <x-table.heading>Receipt_No</x-table.heading>
              <x-table.heading>Session</x-table.heading>
              <x-table.heading>Term</x-table.heading>
              <x-table.heading></x-table.heading>
            </x-slot>

            <x-slot name="body">
              @forelse($cleared as $cl)
                <x-table.row>
                  <x-table.cell>{{ $loop->iteration }}</x-table.cell>
                  <x-table.cell>{{ $cl->payment->title }}</x-table.cell>
                  <x-table.cell>{{ Str::limit($cl->payment->description, 20) }}</x-table.cell>
                  <x-table.cell>{{ $cl->payment->ref_no }}</x-table.cell>
                  <x-table.cell class="fw-bold text-decoration-underline">{{ $cl->payment->amount }}</x-table.cell>
                  <x-table.cell>{{ $cl->ref_no }}</x-table.cell>
                  <x-table.cell>{{ $cl->session }}</x-table.cell>
                  <x-table.cell>{{ $cl->payment->term->name }}</x-table.cell>
                  <x-table.cell>
                    <x-button-link target="_blank" href="{{ route('print_invoice', $cl->id) }}" value="">
                      <i class="bx bx-printer"></i>
                    </x-button-link>
                  </x-table.cell>
                </x-table.row>
              @empty
                <x-table.row>
                  <x-table.cell colspan="9" align="center">No record found</x-table.cell>
                </x-table.row>
              @endforelse
            </x-slot>
          </x-responsive-table>
        </div>
      </div>
    </x-card>
  @endif
</div>
