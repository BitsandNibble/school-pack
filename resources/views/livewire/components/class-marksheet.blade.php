<div>
  <x-card>
    <div class="table-responsive">
      <table class="table table-striped table-sm" style="width:100%">
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
          @if($students)
            @forelse($students as $s)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td></td>
                <td>{{ $s->fullname }}</td>
                <td>{{ $s->school_id }}</td>
                <td>
                  <x-button-link target="_blank" value="danger" href="{{ route('result.marksheet.select_year', [$s->id]) }}">
                    View MarkSheet
                  </x-button-link>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-center">No record found</td>
              </tr>
            @endforelse
          @endif
        </tbody>
      </table>
    </div>
  </x-card>
</div>