<div>
  <x-card>
    <div class="row fw-bolder">
      <div class="col"><p>Subject: {{ $subject }}</p></div>
      <div class="col"><p>Class: {{ $class }}</p></div>
      <div class="col"><p>Exam: {{ $exam }}</p></div>
    </div>
    <div class="table-responsive">
      <table class="table table-striped table-sm" style="width:100%">
        <thead>
          <tr>
            <th>S/N</th>
            <th>Name</th>
            <th>Adm. No</th>
            <th>1st CA ({{ \App\Helpers\SP::getSetting('ca1') }})</th>
            <th>2nd CA ({{ \App\Helpers\SP::getSetting('ca2') }})</th>
            <th>Exam ({{ \App\Helpers\SP::getSetting('exam') }})</th>
          </tr>
        </thead>

        <tbody>
          @if($class_room)
            @forelse($class_room as $class)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $class->student->fullname }}</td>
                <td>{{ $class->student->school_id }}</td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="text-center">No record found</td>
              </tr>
            @endforelse
          @endif
        </tbody>
      </table>
    </div>
  </x-card>
</div>