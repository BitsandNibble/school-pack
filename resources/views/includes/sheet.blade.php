{{--<!--NAME , CLASS AND OTHER INFO -->--}}
<table style="width:100%; border-collapse:collapse; ">
  <tbody>
    <tr>
      <td><strong>NAME:</strong> {{ strtoupper($student_record->fullname) }}</td>
      <td><strong>ADM NO:</strong> {{ $student_record->school_id }}</td>
      <td><strong>CLASS:</strong> {{ strtoupper($class->name) }}</td>
    </tr>
    <tr>
      <td><strong>REPORT SHEET FOR:</strong> {{ strtoupper($term->name) }}</td>
      <td><strong>ACADEMIC YEAR:</strong> {{ $exam_record->year }}</td>
      <td><strong>POSITION:</strong> {!! $position !!}</td>
      {{--      <td><strong>AGE:</strong> {{ $s->age ?: ($sr->user->dob ? date_diff(date_create($sr->user->dob), date_create('now'))->y : '-') }}</td>--}}
    </tr>
  </tbody>
</table>


{{--Exam Table--}}
<x-table class="table-bordered mt-4 text-center" style="border: 1px solid #000; border-collapse: collapse;">
  {{--  <table style="width:100%;  border: 1px solid #000; margin: 10px auto;" border="1">--}}

  <thead>
    <tr>
      <th rowspan="2">SUBJECTS</th>
      <th colspan="3">CONTINUOUS ASSESSMENT</th>
      <th rowspan="2">EXAM<br>({{ $exam_limit }})</th>
      <th rowspan="2">FINAL MARKS <br> ({{ $final_marks }}%)</th>
      <th rowspan="2">GRADE</th>
      <th rowspan="2">SUBJECT <br> POSITION</th>


      {{--  @if($ex->term == 3) --}}{{-- 3rd Term --}}{{--
        <th rowspan="2">FINAL MARKS <br>(100%) 3<sup>RD</sup> TERM</th>
        <th rowspan="2">1<sup>ST</sup> <br> TERM</th>
        <th rowspan="2">2<sup>ND</sup> <br> TERM</th>
        <th rowspan="2">CUM (300%) <br> 1<sup>ST</sup> + 2<sup>ND</sup> + 3<sup>RD</sup></th>
        <th rowspan="2">CUM AVE</th>
        <th rowspan="2">GRADE</th>
        @endif--}}

      <th rowspan="2">REMARKS</th>
    </tr>
    <tr>
      <th>CA1({{ $ca1_limit }})</th>
      <th>CA2({{ $ca2_limit }})</th>
      <th>TOTAL({{ $total_ca_limit }})</th>
    </tr>
  </thead>
  <tbody>
    @foreach($subjects as $sub)
      <tr>
        <td style="font-weight: bold">{{ $sub->subject->name }}</td>
        @foreach($marks->where('subject_id', $sub->subject_id)->where('term_id', $term_id) as $mk)
          <td>{{ $mk->ca1 ?: '-' }}</td>
          <td>{{ $mk->ca2 ?: '-' }}</td>
          <td>{{ $mk->total_ca ?: '-' }}</td>
          <td>{{ $mk->exam_score ?: '-' }}</td>

          <td>{{ $mk->$ts ?: '-'}}</td>
          <td>{{ $mk->grade?->name ?: '-' }}</td>
          <td>{!! ($mk->grade) ? get_suffix($mk->subject_position) : '-' !!}</td>
          <td>{{ $mk->grade?->remark ?: '-' }}</td>

          {{--@if($ex->term == 3)
              <td>{{ $mk->tex3 ?: '-' }}</td>
              <td>{{ Mk::getSubTotalTerm($student_id, $sub->id, 1, $mk->my_class_id, $year) }}</td>
              <td>{{ Mk::getSubTotalTerm($student_id, $sub->id, 2, $mk->my_class_id, $year) }}</td>
              <td>{{ $mk->cum ?: '-' }}</td>
              <td>{{ $mk->cum_ave ?: '-' }}</td>
              <td>{{ $mk->grade ? $mk->grade->name : '-' }}</td>
              <td>{{ $mk->grade ? $mk->grade->remark : '-' }}</td>
          @endif--}}

        @endforeach
      </tr>
    @endforeach
    <tr>
      <td colspan="3"><strong>TOTAL SCORES OBTAINED: </strong> {{ $exam_record->total }}</td>
      <td colspan="3"><strong>FINAL AVERAGE: </strong> {{ $exam_record->average }}</td>
      <td colspan="3"><strong>CLASS AVERAGE: </strong> {{ $exam_record->class_average }}</td>
    </tr>
  </tbody>
</x-table>
