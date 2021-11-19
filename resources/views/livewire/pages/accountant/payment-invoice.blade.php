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
          <thead>
            <tr>
              <th>S/N</th>
              <th>Title</th>
              <th>Desc</th>
              <th>Pay_Ref</th>
              <th>Amount</th>
              <th>Paid</th>
              <th>Balance</th>
              <th>Pay Now</th>
              <th>Receipt_No</th>
              <th>Year</th>
              <th></th>
            </tr>
          </thead>

          <tbody>
            @forelse($uncleared as $index => $uc)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $uc->payment->title }}</td>
                <td>{{ Str::limit($uc->payment->description, 20) }}</td>
                <td>{{ $uc->payment->ref_no }}</td>
                <td class="fw-bold">{{ $uc->payment->amount }}</td>
                <td class="text-info">{{ $uc->amount_paid ?: '0.00' }}</td>
                <td class="text-danger">{{ $uc->balance ?: $uc->payment->amount }}</td>
                <td>
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
                </td>
                <td>{{ $uc->ref_no }}</td>
                <td>{{ $uc->year }}</td>
                <td>
                  <x-button wire:click="reset_record({{ $uc->id }})" value=""
                            onclick="return confirm('Are you sure you want to reset this payment?') || event.stopImmediatePropagation()">
                    <i class="bx bx-refresh"></i>
                  </x-button>

                  <x-button-link target="_blank" href="{{ route('print_invoice', $uc->id) }}" value="">
                    <i class="bx bx-printer"></i>
                  </x-button-link>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="10" align="center">No record found</td>
              </tr>
            @endforelse
          </tbody>
        </x-responsive-table>
      </div>

      <div class="tab-pane fade" id="complete" role="tabpanel">
        <x-responsive-table>
          <thead>
            <tr>
              <th>S/N</th>
              <th>Title</th>
              <th>Desc</th>
              <th>Pay_Ref</th>
              <th>Amount</th>
              <th>Receipt_No</th>
              <th>Year</th>
              <th></th>
            </tr>
          </thead>

          <tbody>
            @forelse($cleared as $cl)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $cl->payment->title }}</td>
                <td>{{ Str::limit($cl->payment->description, 20) }}</td>
                <td>{{ $cl->payment->ref_no }}</td>
                <td class="fw-bold">{{ $cl->payment->amount }}</td>
                <td>{{ $cl->ref_no }}</td>
                <td>{{ $cl->year }}</td>
                <td>
                  <x-button wire:click="reset_record({{ $cl->id }})" value=""
                            onclick="return confirm('Are you sure you want to reset this payment?') || event.stopImmediatePropagation()">
                    <i class="bx bx-refresh"></i>
                  </x-button>

                  <x-button-link target="_blank" href="{{ route('print_invoice', $cl->id) }}" value="">
                    <i class="bx bx-printer"></i>
                  </x-button-link>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" align="center">No record found</td>
              </tr>
            @endforelse
          </tbody>
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
