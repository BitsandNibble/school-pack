<div>
  @if($class_id)
    <x-card>
      <div class="fw-bolder mb-2">
        Tabulation Sheet for {{ $class }} - {{ $exam_name }} @if($class_id)
          ({{ $selected_year }}) @endif
      </div>

      <x-responsive-table>
        <thead>
          <tr>
            <th>S/N</th>
            <th>Name</th>
            @foreach($subjects as $sub)
              <th>{{ $sub->subject->slug ?:  $sub->subject->name }}</th>
            @endforeach
            <th class="text-danger">Total</th>
            <th class="text-primary">Average</th>
            <th class="text-info">Position</th>
          </tr>
        </thead>

        <tbody>
          @forelse($students as $s)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $s->student->fullname }}</td>
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
        </tbody>
      </x-responsive-table>

      <div class="d-block mb-2 text-center">
        <x-button-link target="_blank" href="{{ route('print_tabulation_sheet', [$exam_id, $class_id]) }}"><i
              class="bx bx-printer"></i>Print Tabulation Sheet
        </x-button-link>
      </div>
    </x-card>
  @endif

  @push('scripts')
    <script>
        $(document).ready(function () {
            $(".wrapper").addClass("toggled");
            $(".sidebar-wrapper").hover(function () {
                $(".wrapper").addClass("sidebar-hovered");
            }, function () {
                $(".wrapper").removeClass("sidebar-hovered");
            })
        });
    </script>
  @endpush
</div>