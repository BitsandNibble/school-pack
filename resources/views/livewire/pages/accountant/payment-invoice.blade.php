<div>
  <x-flash />

  <x-card-with-header>
    <x-slot name="header">
      <h6 class="fw-bold my-auto">Manage Payment Records for {{ $student }}</h6>
    </x-slot>

    <div class="table-responsive">
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
          @forelse($payment_records as $pr)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $pr->payment->title ?? '' }}</td>
              <td>{{ $pr->ref_no ?? '' }}</td>
              <td>{{ $pr->payment->amount ?? '' }}</td>
              <td>{{ $pr->amount_paid ?? '' }}</td>
              <td>
                <x-input type="number" />
              </td>
              <td>{{ $pr->balance ?? '' }}</td>
              <td>{{ $pr->receipt ?? '' }}</td>
              <td>{{ $pr->year ?? '' }}</td>
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

  </x-card-with-header>
</div>
