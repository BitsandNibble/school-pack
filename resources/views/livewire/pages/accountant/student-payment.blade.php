<div>
  @if($selected_class)
    <x-flash />

    <x-card>
      <div class="table-responsive">
        <table class="table table-striped table-sm" style="width:100%">
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
                <td>{{ $st->fullname ?? '' }}</td>
                <td>{{ $st->school_id ?? '' }}</td>
                <td></td>
              </tr>
            @empty
              <tr>
                <td colspan="4" align="center">No record found</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </x-card>

    <x-spinner />
  @endif
</div>
