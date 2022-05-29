<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Student Marksheet - {{ $student_record->fullname }}</title>

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
                        <td><img src="{{ get_school_logo() }}" class="rounded-circle p-1" width="110" alt="Logo"></td>

                        <td style="text-align: center; ">
                            <strong><span
                                        style="color: #1b0c80; font-size: 25px;">{{ strtoupper(get_setting('school_name')) }}</span></strong><br />
                            <strong><span
                                        style="color: #000; font-size: 15px;"><i>{{ ucwords($s['address']) }}</i></span></strong><br />
                            <strong><span style="color: #000; font-size: 15px;"> REPORT SHEET
                                    ({{ strtoupper($class_type->name) }})
                                </span></strong>
                        </td>
                        <td style="width: 100px; height: 100px; float: left;">
                            <img src="{{ $student_record->thumbnail }}" class="rounded-circle p-1" width="110"
                                 alt="Preview">
                        </td>
                    </tr>
                </table>
                <br />

                {{--Background Logo--}}
                <div style="position: relative;  text-align: center; ">
                    <img alt="" src="{{ get_school_logo() }}" class="rounded-circle"
                         style="max-width: 500px; max-height:600px; margin-top: 60px; position:absolute ; opacity: 0.2; margin-left: auto;margin-right: auto; left: 0; right: 0;" />
                </div>

                {{--         SHEET --}}
                @include('includes.sheet')

                <br> <br>

                {{--        SKILLS--}}
                @include('includes.skills')

                <br> <br>

                {{--    COMMENTS & SIGNATURE    --}}
                @include('includes.comments')

            </div>
        </div>

        <script>
            window.print();
        </script>
    </body>

</html>
