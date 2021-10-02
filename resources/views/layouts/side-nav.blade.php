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
    <a href="{{ route('principal.students') }}">
      <div class="parent-icon"><i class='lni lni-users'></i></div>
      <div class="menu-title">Students</div>
    </a>
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
    </ul>
  </li>

  <li>
    <a href="{{ route('principal.results') }}">
      <div class="parent-icon"><i class='bx bx-notepad'></i></div>
      <div class="menu-title">Results</div>
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
      <a href="{{ route('teacher.classes.students', [$section->class_room->slug, $section->name]) }}">
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
        <a href="{{ route('teacher.exams') }}"><i class="bx bx-right-arrow-alt"></i>Exam</a>
      </li>
    </ul>
  </li>
@endif
