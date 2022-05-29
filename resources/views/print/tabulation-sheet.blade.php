<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {{--    <title>Tabulation Sheet - {{ $student_record->fullname }}</title>--}}
        {{--    <title>Tabulation Sheet - {{ $class->name.' '.$section->name.' - '.$ex->name.' ('.$year.')' }}</title>--}}
        <title>Tabulation Sheet - {{ $class->name . ' - ' . $term->name . ' ('.$year.')' }}</title>

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
        {{--    <link rel="stylesheet" href="{{ asset('assets/css/icons.css') }}">--}}

        <style>
            body {
                color: black;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <div>
                {{--    Logo N School Details--}}
                <table width="100%">
                    <tr>
                        <td><img alt="..." src="{{ get_school_logo() }}" style="max-height : 100px;"></td>

                        <td style="text-align: center; ">
                            <strong><span
                                        style="color: #1b0c80; font-size: 25px;">{{ strtoupper(get_setting('school_name')) }}</span></strong><br />
                            <strong><span
                                        style="color: #000; font-size: 15px;"><i>{{ ucwords($s['address']) }}</i></span></strong><br />
                            <strong><span style="color: #000; font-size: 15px;"> TABULATION SHEET
                                    FOR {{ strtoupper($class->name . ' - ' . $term->name . ' ('.$year.')') }}

                                </span></strong>
                        </td>
                    </tr>
                </table>
                <br />

                {{--Background Logo--}}
                <div style="position: relative;  text-align: center; ">
                    <img alt="" src="{{ get_school_logo() }}"
                         style="max-width: 500px; max-height:600px; margin-top: 60px; position:absolute ; opacity: 0.2; margin-left: auto;margin-right: auto; left: 0; right: 0;" />
                </div>

                {{-- Tabulation Begins --}}
                <table class="table table-bordered table-sm mt-4 text-center"
                       style="width:100%; border: 1px solid #000; border-collapse:collapse;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>NAMES</th>
                            @foreach($subjects as $sub)
                                <th>{{ strtoupper($sub->slug ?: $sub->name) }}</th>
                            @endforeach
                            {{--   @if($ex->term == 3)
                                   <th>1ST TERM TOTAL</th>
                                   <th>2ND TERM TOTAL</th>
                                   <th>3RD TERM TOTAL</th>
                                   <th style="color: darkred">CUM Total</th>
                                   <th style="color: darkblue">CUM Average</th>
                               @endif--}}
                            <th style="color: darkred">Total</th>
                            <th style="color: darkblue">Average</th>
                            <th style="color: darkgreen">Position</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $s)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td style="text-align: center">{{ $s->fullname }}</td>
                                @foreach($subjects as $sub)
                                    <td>{{ $marks->where('student_id', $s->id)->where('subject_id', $sub->id)->first()->$ts ?? '-' }}</td>
                                @endforeach

                                {{--@if($ex->term == 3)
                                    --}}{{--1st term Total--}}{{--
                                    <td>{{ Mk::getTermTotal($s->user_id, 1, $year) ?: '-' }}</td>
                                    --}}{{--2nd Term Total--}}{{--
                                    <td>{{ Mk::getTermTotal($s->user_id, 2, $year) ?: '-' }}</td>
                                    --}}{{--3rd Term total--}}{{--
                                    <td>{{ Mk::getTermTotal($s->user_id, 3, $year) ?: '-' }}</td>
                                @endif--}}

                                <td style="color: darkred">{{ $exam_record->where('student_id', $s->id)->first()->total ?: '-' }}</td>
                                <td style="color: darkblue">{{ $exam_record->where('student_id', $s->id)->first()->average ?: '-' }}</td>
                                <td style="color: darkgreen">{!! get_suffix($exam_record->where('student_id', $s->id)->first()->position) ?: '-' !!}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <script>
            window.print();
        </script>
    </body>
</html>
