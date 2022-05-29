{{--principal side nav--}}
@if(auth('principal')->user())

{{ route('principal.home') }}








{{ route('principal.teachers') }}












{{ route('principal.students') }}


{{ route('principal.students.promote') }}


{{ route('principal.students.manage-promotion') }}















{{ route('create-payment') }}


{{ route('manage-payment') }}


{{ route('student-payment') }}


{{ route('payment.debtors') }}











{{ route('principal.classes') }}


{{ route('principal.sections') }}





{{ route('principal.subjects') }}












{{ route('principal.terms') }}


{{ route('principal.grades') }}


{{ route('principal.scores') }}


{{ route('principal.skills') }}











{{ route('principal.result.tabulated') }}


{{ route('principal.result.marksheet') }}





{{ route('principal.notice-board') }}




@endif


{{--teacher side nav--}}
@if(auth('teacher')->user())

{{ route('teacher.home') }}





@foreach($sec as $section)

{{ route('teacher.classes.students', [$section->class_room->slug, $section]) }}


{{ $section->class_room->name . ' ' . $section->name }}



@endforeach


{{ route('teacher.subjects') }}












{{ route('teacher.scores') }}











{{ route('teacher.result.tabulated') }}


{{ route('teacher.result.marksheet') }}



@endif


{{--student side nav--}}
@if(auth('student')->user())

{{ route('student.home') }}












{{ route('student.select-session') }}











{{ route('student.payment') }}



@endif


{{--accountant side nav--}}
@if(auth('accountant')->user())

{{ route('accountant.home') }}












{{ route('create-payment') }}


{{ route('manage-payment') }}


{{ route('student-payment') }}


{{ route('payment.debtors') }}



@endif
