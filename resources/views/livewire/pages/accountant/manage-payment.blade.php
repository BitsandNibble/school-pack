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
  @endif
</div>
