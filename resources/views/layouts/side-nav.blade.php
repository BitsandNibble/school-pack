{{--principal side nav--}}
@if(auth('principal')->user())
  <li>
    <a href="{{ route('principal.home') }}">
      <div class="parent-icon"><i class='bx bx-home'></i></div>
      <div class="menu-title">Dashboard</div>
    </a>
  </li>

  <li class="menu-label">Pages</li>

  <li>
    <a href="{{ route('principal.teachers') }}">
      <div class="parent-icon"><i class='bx bxs-user'></i></div>
      <div class="menu-title">Teachers</div>
    </a>
  </li>

  <li>
    <a href="javascript:" class="has-arrow" aria-expanded="false">
      <div class="parent-icon"><i class='bx bx-home-circle'></i></div>
      <div class="menu-title">Students</div>
    </a>
    <ul class="mm-collapse">
      <li>
        <a href="{{ route('principal.students') }}"><i class="bx bx-right-arrow-alt"></i>View Students</a>
      </li>
      <li>
        <a href="{{ route('principal.students.promote') }}"><i class="bx bx-right-arrow-alt"></i>Promote Students</a>
      </li>
      <li>
        <a href="{{ route('principal.students.manage-promotion') }}"><i class="bx bx-right-arrow-alt"></i>Manage
          Promotions</a>
      </li>
      <li>
        <a><i class="bx bx-right-arrow-alt"></i>Graduated</a>
      </li>
    </ul>
  </li>

  <li>
    <a href="javascript:" class="has-arrow" aria-expanded="false">
      <div class="parent-icon"><i class='bx bx-money'></i></div>
      <div class="menu-title">Payments</div>
    </a>
    <ul class="mm-collapse">
      <li>
        <a href="{{ route('create-payment') }}"><i class="bx bx-right-arrow-alt"></i>Create Payment</a>
      </li>
      <li>
        <a href="{{ route('manage-payment') }}"><i class="bx bx-right-arrow-alt"></i>Manage Payment</a>
      </li>
      <li>
        <a href="{{ route('student-payment') }}"><i class="bx bx-right-arrow-alt"></i>Student Payments</a>
      </li>
      <li>
        <a href="{{ route('payment.debtors') }}"><i class="bx bx-right-arrow-alt"></i>Debtors</a>
      </li>
    </ul>
  </li>

  <li>
    <a href="javascript:" class="has-arrow" aria-expanded="false">
      <div class="parent-icon"><i class='bx bx-home-circle'></i></div>
      <div class="menu-title">Classes</div>
    </a>
    <ul class="mm-collapse">
      <li>
        <a href="{{ route('principal.classes') }}"><i class="bx bx-right-arrow-alt"></i>Classes</a>
      </li>
      <li>
        <a href="{{ route('principal.sections') }}"><i class="bx bx-right-arrow-alt"></i>Sections</a>
      </li>
    </ul>
  </li>

  <li>
    <a href="{{ route('principal.subjects') }}">
      <div class="parent-icon"><i class='bx bx-book'></i></div>
      <div class="menu-title">Subjects</div>
    </a>
  </li>

  <li>
    <a href="javascript:" class="has-arrow" aria-expanded="false">
      <div class="parent-icon"><i class='bx bx-note'></i></div>
      <div class="menu-title">Grading</div>
    </a>
    <ul class="mm-collapse">
      <li>
        <a href="{{ route('principal.exams') }}"><i class="bx bx-right-arrow-alt"></i>Exam</a>
      </li>
      <li>
        <a href="{{ route('principal.grades') }}"><i class="bx bx-right-arrow-alt"></i>Grades</a>
      </li>
      <li>
        <a href="{{ route('principal.scores') }}"><i class="bx bx-right-arrow-alt"></i>Scores</a>
      </li>
      <li>
        <a href="{{ route('principal.skills') }}"><i class="bx bx-right-arrow-alt"></i>Skills</a>
      </li>
    </ul>
  </li>

  <li>
    <a href="javascript:" class="has-arrow" aria-expanded="false">
      <div class="parent-icon"><i class='bx bx-paperclip'></i></div>
      <div class="menu-title">Results</div>
    </a>
    <ul class="mm-collapse">
      <li>
        <a href="{{ route('principal.result.tabulated') }}"><i class="bx bx-right-arrow-alt"></i>Tabulation Sheet</a>
      </li>
      <li>
        <a href="{{ route('principal.result.marksheet') }}"><i class="bx bx-right-arrow-alt"></i>Mark Sheet</a>
      </li>
    </ul>
  </li>

  <li>
    <a href="{{ route('principal.notice-board') }}">
      <div class="parent-icon"><i class='bx bx-tab'></i></div>
      <div class="menu-title">Notice Board</div>
    </a>
  </li>
@endif


{{--teacher side nav--}}
@if(auth('teacher')->user())
  <li>
    <a href="{{ route('teacher.home') }}">
      <div class="parent-icon"><i class='bx bx-home'></i></div>
      <div class="menu-title">Dashboard</div>
    </a>
  </li>

  @foreach($sec as $section)
    <li>
      <a href="{{ route('teacher.classes.students', [$section->class_room->slug, $section]) }}">
        <div class="parent-icon"><i class='lni lni-users'></i></div>
        <div class="menu-title">
          {{ $section->class_room->name . ' ' . $section->name }}
        </div>
      </a>
    </li>
  @endforeach

  <li>
    <a href="{{ route('teacher.subjects') }}">
      <div class="parent-icon"><i class='bx bx-book'></i></div>
      <div class="menu-title">Subjects</div>
    </a>
  </li>

  <li>
    <a href="javascript:" class="has-arrow" aria-expanded="false">
      <div class="parent-icon"><i class='bx bx-note'></i></div>
      <div class="menu-title">Grading</div>
    </a>
    <ul class="mm-collapse">
      <li>
        <a href="{{ route('teacher.scores') }}"><i class="bx bx-right-arrow-alt"></i>Scores</a>
      </li>
    </ul>
  </li>

  <li>
    <a href="javascript:" class="has-arrow" aria-expanded="false">
      <div class="parent-icon"><i class='bx bx-paperclip'></i></div>
      <div class="menu-title">Results</div>
    </a>
    <ul class="mm-collapse">
      <li>
        <a href="{{ route('teacher.result.tabulated') }}"><i class="bx bx-right-arrow-alt"></i>Tabulation Sheet</a>
      </li>
      <li>
        <a href="{{ route('teacher.result.marksheet') }}"><i class="bx bx-right-arrow-alt"></i>Mark Sheet</a>
      </li>
    </ul>
  </li>
@endif


{{--student side nav--}}
@if(auth('student')->user())
  <li>
    <a href="{{ route('student.home') }}">
      <div class="parent-icon"><i class='bx bx-home'></i></div>
      <div class="menu-title">Dashboard</div>
    </a>
  </li>

  <li>
    <a href="javascript:" class="has-arrow" aria-expanded="false">
      <div class="parent-icon"><i class='bx bx-paperclip'></i></div>
      <div class="menu-title">Results</div>
    </a>
    <ul class="mm-collapse">
      <li>
        <a href="{{ route('student.select-year') }}"><i class="bx bx-right-arrow-alt"></i>Mark Sheet</a>
      </li>
    </ul>
  </li>
@endif


{{--accountant side nav--}}
@if(auth('accountant')->user())
  <li>
    <a href="{{ route('accountant.home') }}">
      <div class="parent-icon"><i class='bx bx-home'></i></div>
      <div class="menu-title">Dashboard</div>
    </a>
  </li>

  <li>
    <a href="javascript:" class="has-arrow" aria-expanded="false">
      <div class="parent-icon"><i class='bx bx-money'></i></div>
      <div class="menu-title">Payments</div>
    </a>
    <ul class="mm-collapse">
      <li>
        <a href="{{ route('create-payment') }}"><i class="bx bx-right-arrow-alt"></i>Create Payment</a>
      </li>
      <li>
        <a href="{{ route('manage-payment') }}"><i class="bx bx-right-arrow-alt"></i>Manage Payment</a>
      </li>
      <li>
        <a href="{{ route('student-payment') }}"><i class="bx bx-right-arrow-alt"></i>Student Payments</a>
      </li>
      <li>
        <a href="{{ route('payment.debtors') }}"><i class="bx bx-right-arrow-alt"></i>Debtors</a>
      </li>
    </ul>
  </li>
@endif
