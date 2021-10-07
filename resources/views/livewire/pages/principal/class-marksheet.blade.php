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
                  <form action="{{ route('teacher.result.marksheet.year') }}" method="POST">
                    @csrf
                    <x-input type="hidden" value="{{ $s->id }}" name="id"></x-input>
                    <x-button type="submit" value="danger">View Marksheet</x-button>
                  </form>
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