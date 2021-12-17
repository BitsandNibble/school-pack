<div>
  <x-card-with-header>
    <x-slot name="header">
      <h6 class="fw-bold my-auto">Manage Payment Records for {{ $student }}</h6>
    </x-slot>

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
          <x-validation-errors />
          <x-slot name="head">
            <x-table.heading>S/N</x-table.heading>
            <x-table.heading>Title</x-table.heading>
            <x-table.heading>Desc</x-table.heading>
            <x-table.heading>Pay_Ref</x-table.heading>
            <x-table.heading>Amount</x-table.heading>
            <x-table.heading>Paid</x-table.heading>
            <x-table.heading>Balance</x-table.heading>
            <x-table.heading>Pay Now</x-table.heading>
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
                <x-table.cell>
                  <div class="row">
                    <div class="col-md-7">
                      <x-input class="form-control-sm" type="text" placeholder="Pay Now"
                               wire:model.defer="amount_paid.{{ $index }}" />
                      {{--                    <x-input class="form-control-sm" placeholder="Pay Now" max="{{ $uc->balance ?: $uc->payment->amount }}" wire:model.defer="amount_paid.{{ $index }}" />--}}
                    </div>
                    <div class="col-md-5">
                      <x-button value="danger" wire:click.prevent="pay({{ $uc->id }})">Pay <i
                            class="bx bxs-paper-plane"></i></x-button>
                    </div>
                  </div>
                </x-table.cell>
                <x-table.cell>{{ $uc->ref_no }}</x-table.cell>
                <x-table.cell>{{ $uc->session }}</x-table.cell>
                <x-table.cell>{{ $uc->payment->term->name }}</x-table.cell>
                <x-table.cell>
                  <x-button wire:click="reset_record({{ $uc->id }})" value=""
                            onclick="return confirm('Are you sure you want to reset this payment?') || event.stopImmediatePropagation()">
                    <i class="bx bx-refresh"></i>
                  </x-button>

                  <x-button-link target="_blank" href="{{ route('print_invoice', $uc->id) }}" value="">
                    <i class="bx bx-printer"></i>
                  </x-button-link>
                </x-table.cell>
              </x-table.row>
            @empty
              <x-table.row>
                <x-table.cell colspan="12" align="center">No record found</x-table.cell>
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
                  <x-button wire:click="reset_record({{ $cl->id }})" value=""
                            onclick="return confirm('Are you sure you want to reset this payment?') || event.stopImmediatePropagation()">
                    <i class="bx bx-refresh"></i>
                  </x-button>

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
  </x-card-with-header>
  <x-spinner />

  @push('scripts')
    <script>
        $(document).ready(function () {
            $(".wrapper").addClass("toggled");
            $(".sidebar-wrapper").hover(function () {
                $(".wrapper").addClass("sidebar-hovered");
            }, function () {
                $(".wrapper").removeClass("sidebar-hovered");
            })
        });
    </script>
  @endpush
</div>
