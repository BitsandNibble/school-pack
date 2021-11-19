<div>
  <x-breadcrumb>
    Financials
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

  @if($class)
    <x-card>
      <x-responsive-table>
        <thead>
          <tr>
            <th>S/N</th>
            <th>Name</th>
            <th>Adm No</th>
            <th>Payments</th>
          </tr>
        </thead>

        <tbody>
          @forelse($students as $st)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $st->fullname }}</td>
              <td>{{ $st->school_id }}</td>
              <td>
                <div class="dropdown">
                  <x-button class="dropdown-toggle" value="danger" data-bs-toggle="dropdown" aria-expanded="false">
                    Manage Payments
                  </x-button>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" target="_blank"
                           href="{{ route('payment.invoice', [$st->id]) }}">
                        All Payments</a>
                    </li>
                    @foreach($payments->where('student_id', $st->id)->pluck('year')->unique() as $year)
                      <li><a class="dropdown-item" target="_blank"
                             href="{{ route('payment.invoice', [$st->id, $year]) }}">
                          {{ $year }}</a>
                      </li>
                    @endforeach
                  </ul>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="4" align="center">No record found</td>
            </tr>
          @endforelse
        </tbody>
      </x-responsive-table>
    </x-card>
  @endif
</div>
