<div>
  @if($students)
    <x-card>
      <x-responsive-table>
        <thead>
          <tr>
            <th>S/N</th>
            <th>Photo</th>
            <th>Name</th>
            <th>Adm. No</th>
            <th></th>
          </tr>
        </thead>

        <tbody>
          @forelse($students as $st)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td></td>
              <td>{{ $st->fullname }}</td>
              <td>{{ $st->school_id }}</td>
              <td>
                <div class="dropdown">
                  <x-button class="dropdown-toggle" value="danger" data-bs-toggle="dropdown" aria-expanded="false">
                    View Marksheet
                  </x-button>
                  <ul class="dropdown-menu">
                    @foreach($marks->where('student_id', $st->id)->pluck('year')->unique() as $year)
                      <li><a class="dropdown-item" target="_blank"
                             href="{{ route('result.marksheet.show', [$st->id, $year]) }}">
                          {{ $year }}</a>
                      </li>
                    @endforeach
                  </ul>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="text-center">No record found</td>
            </tr>
          @endforelse
        </tbody>
      </x-responsive-table>

    </x-card>
  @endif
</div>