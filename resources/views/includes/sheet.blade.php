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

    <x-slot name="head">
        <x-table.heading rowspan="2">SUBJECTS</x-table.heading>
        <x-table.heading colspan="3">CONTINUOUS ASSESSMENT</x-table.heading>
        <x-table.heading rowspan="2">EXAM<br>({{ $exam_limit }})</x-table.heading>
        <x-table.heading rowspan="2">FINAL MARKS <br> ({{ $final_marks }}%)</x-table.heading>
        <x-table.heading rowspan="2">GRADE</x-table.heading>
        <x-table.heading rowspan="2">SUBJECT <br> POSITION</x-table.heading>


        {{--  @if($ex->term == 3) --}}{{-- 3rd Term --}}{{--
          <x-table.heading rowspan="2">FINAL MARKS <br>(100%) 3<sup>RD</sup> TERM</x-table.heading>
          <x-table.heading rowspan="2">1<sup>ST</sup> <br> TERM</x-table.heading>
          <x-table.heading rowspan="2">2<sup>ND</sup> <br> TERM</x-table.heading>
          <x-table.heading rowspan="2">CUM (300%) <br> 1<sup>ST</sup> + 2<sup>ND</sup> + 3<sup>RD</sup></x-table.heading>
          <x-table.heading rowspan="2">CUM AVE</x-table.heading>
          <x-table.heading rowspan="2">GRADE</x-table.heading>
          @endif--}}

        <x-table.heading rowspan="2">REMARKS</x-table.heading>
        <x-table.row>
            <x-table.heading>CA1({{ $ca1_limit }})</x-table.heading>
            <x-table.heading>CA2({{ $ca2_limit }})</x-table.heading>
            <x-table.heading>TOTAL({{ $total_ca_limit }})</x-table.heading>
        </x-table.row>
    </x-slot>

    <x-slot name="body">
        @foreach($subjects as $sub)
            <x-table.row>
                <td style="font-weight: bold">{{ $sub->subject->name }}</td>
                @foreach($marks->where('subject_id', $sub->subject_id)->where('term_id', $term_id) as $mk)
                    <x-table.cell>{{ $mk->ca1 ?: '-' }}</x-table.cell>
                    <x-table.cell>{{ $mk->ca2 ?: '-' }}</x-table.cell>
                    <x-table.cell>{{ $mk->total_ca ?: '-' }}</x-table.cell>
                    <x-table.cell>{{ $mk->exam_score ?: '-' }}</x-table.cell>

                    <x-table.cell>{{ $mk->$ts ?: '-'}}</x-table.cell>
                    <x-table.cell>{{ $mk->grade?->name ?: '-' }}</x-table.cell>
                    <x-table.cell>{!! ($mk->grade) ? get_suffix($mk->subject_position) : '-' !!}</x-table.cell>
                    <x-table.cell>{{ $mk->grade?->remark ?: '-' }}</x-table.cell>

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
            </x-table.row>
        @endforeach
        <x-table.row>
            <x-table.cell colspan="3"><strong>TOTAL SCORES OBTAINED: </strong> {{ $exam_record->total }}</x-table.cell>
            <x-table.cell colspan="3"><strong>FINAL AVERAGE: </strong> {{ $exam_record->average }}</x-table.cell>
            <x-table.cell colspan="3"><strong>CLASS AVERAGE: </strong> {{ $exam_record->class_average }}</x-table.cell>
        </x-table.row>
    </x-slot>
</x-table>
