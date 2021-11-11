<div>
  @if($selected_class)
    <x-flash />

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

    <x-spinner />
  @endif
</div>
