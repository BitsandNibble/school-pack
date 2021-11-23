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
          @foreach($years as $sess)
            <option value="{{ $sess->year }}" selected>{{ $sess->year }}</option>
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
            <thead>
              <tr>
                <th>S/N</th>
                <th>Title</th>
                <th>Desc</th>
                <th>Pay_Ref</th>
                <th>Amount</th>
                <th>Paid</th>
                <th>Balance</th>
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
                  <td>{{ $uc->ref_no }}</td>
                  <td>{{ $uc->year }}</td>
                  <td>
                    <x-button-link target="_blank" href="{{ route('print_invoice', $uc->id) }}" value="">
                      <i class="bx bx-printer"></i>
                    </x-button-link>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="9" align="center">No record found</td>
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
    </x-card>
  @endif
</div>
