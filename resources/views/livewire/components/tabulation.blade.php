<div>
  <x-card>
    <div class="fw-bolder mb-2">
      Tabulation Sheet for {{ $class }} - {{ $exam_name }} @if($class_id)
        ({{ \App\Helpers\SP::getSetting('current_session') }}) @endif
    </div>

    <div class="table-responsive">
      <table class="table table-striped table-sm" style="width:100%">
        <thead>
          <tr>
            <th>S/N</th>
            <th>Name</th>
            @if($class_id)
              @foreach($subjects as $sub)
                <th>{{ $sub->subject->slug ?:  $sub->subject->name }}</th>
              @endforeach
            @endif
            <th class="text-danger">Total</th>
            <th class="text-primary">Average</th>
            <th class="text-info">Position</th>
          </tr>
        </thead>

        <tbody>
          @if($class_id)
            @forelse($students as $s)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $s->student->fullname ?? '' }}</td>
                @foreach($subjects as $sub)
                  <td>{{ $marks->where('student_id', $s->student_id)->where('subject_id', $sub->subject_id)->first()->total_score ?? '-' }}</td>
                @endforeach
                <td class="text-danger">{{ $exam->where('student_id', $s->student_id)->first()->total ?? '' }}</td>
                <td class="text-primary">{{ $exam->where('student_id', $s->student_id)->first()->average ?? '' }}</td>
                <td class="text-info">{!! \App\Helpers\SP::getSuffix($exam->where('student_id', $s->student_id)->first()->position) ?? '' !!}</td>
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

    <div class="d-block mb-2 text-center">
      <x-button-link target="_blank" href="{{ route('print_tabulation_sheet', [$exam_id, $class_id]) }}"><i
            class="bx bx-printer"></i>Print Mark Sheet
      </x-button-link>
    </div>
  </x-card>
</div>