<x-app-layout>
  <x-breadcrumb>
    Results
    <li class="breadcrumb-item active" aria-current="page">Mark Sheet</li>
    <li class="breadcrumb-item active" aria-current="page">Student Mark Sheet</li>
  </x-breadcrumb>

  <x-card>
    <h5> Student Marksheet for {{ $student->fullname }}
      ({{ $student->class_room->name . ' ' . $student->section->name }})
    </h5>
  </x-card>

  <x-card>
    <h5 class="mb-4">{{ $exam_record->exam->name . ' - ' . $exam_record->year }}</h5>

    <div class="table-responsive">
      <table class="table table-bordered text-center" style="width:100%">
        {{--        <table class="table table-bordered table-sm mt-4 text-center" style="width:100%; border: 1px solid #000; border-collapse:collapse;">--}}

        <thead>
          <tr>
            <th>S/N</th>
            <th>SUBJECTS</th>
            <th>CA1 <br> ({{ $ca1_limit }})</th>
            <th>CA2 <br> ({{ $ca2_limit }})</th>
            <th>EXAM <br> ({{ $exam_limit }})</th>
            <th>TOTAL <br> ({{ $total }})</th>
            <th>GRADE</th>
            <th>SUBJECT <br> POSITION</th>
            <th>REMARKS</th>
          </tr>
        </thead>

        <tbody>
          @foreach($marks as $mark)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $mark->subject->name }}</td>
              <td>{{ $mark->ca1 }}</td>
              <td>{{ $mark->ca2 }}</td>
              <td>{{ $mark->exam_score }}</td>
              <td>{{ $mark->total_score }}</td>
              <td>{{ $mark->grade->name }}</td>
              <td>{!! \App\Helpers\SP::getSuffix($mark->subject_position) !!}</td>
              <td>{{ $mark->grade->remark }}</td>
            </tr>
          @endforeach
          <tr>
            <td colspan="3"><strong>TOTAL SCORES OBTAINED: </strong> {{ $exam_record->total }}</td>
            <td colspan="3"><strong>FINAL AVERAGE: </strong> {{ $exam_record->average }}</td>
            <td colspan="2"><strong>CLASS AVERAGE: </strong> {{ $exam_record->class_average }}</td>
            <td><strong>POSITION: </strong> {!! $position !!}</td>
          </tr>
        </tbody>

      </table>
    </div>

    <div class="d-block mb-2 text-center">
      <x-button-link target="_blank"
                     href="{{ route('print_marksheet', [$student->id, $exam_record->exam_id, $exam_record->year]) }}"><i
            class="bx bx-printer"></i>Print Mark Sheet
      </x-button-link>
    </div>
  </x-card>

  @auth('student')
  @else
    <livewire:components.comment :id="$student->id" />
  @endauth

</x-app-layout>