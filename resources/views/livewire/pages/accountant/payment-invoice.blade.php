<div>
  <x-flash />

  <x-card-with-header>
    <x-slot name="header">
      <h6 class="fw-bold my-auto">Manage Payment Records for {{ $student }}</h6>
    </x-slot>

    <div class="table-responsive">
      <x-validation-errors />
      <table class="table table-striped table-sm" style="width:100%">
        <thead>
          <tr>
            <th>S/N</th>
            <th>Title</th>
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
              <td>{{ $uc->payment->title ?? '' }}</td>
              <td>{{ $uc->payment->ref_no ?? '' }}</td>
              <td class="fw-bold">{{ $uc->payment->amount ?? '' }}</td>
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
              <td>{{ $uc->ref_no ?? '' }}</td>
              <td>{{ $uc->year ?? '' }}</td>
              <td></td>
            </tr>
          @empty
            <tr>
              <td colspan="10" align="center">No record found</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="table-responsive">
      <table class="table table-striped table-sm" style="width:100%">
        <thead>
          <tr>
            <th>S/N</th>
            <th>Title</th>
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
              <td>{{ $cl->payment->title ?? '' }}</td>
              <td>{{ $cl->payment->ref_no ?? '' }}</td>
              <td class="fw-bold">{{ $cl->payment->amount ?? '' }}</td>
              <td>{{ $cl->ref_no ?? '' }}</td>
              <td>{{ $cl->year ?? '' }}</td>
              <td></td>
            </tr>
          @empty
            <tr>
              <td colspan="7" align="center">No record found</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

  </x-card-with-header>
</div>
