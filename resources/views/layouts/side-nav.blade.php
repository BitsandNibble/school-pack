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
    <a href="{{ route('principal.classes') }}">
      <div class="parent-icon"><i class='bx bx-home-circle'></i></div>
      <div class="menu-title">Classes</div>
    </a>
  </li>

  <li>
    <a href="{{ route('principal.subjects') }}">
      <div class="parent-icon"><i class='bx bx-book'></i></div>
      <div class="menu-title">Subjects</div>
    </a>
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

  @foreach(auth()->user()->classes as $class)
    <li>
      <a href="{{ route('teacher.classes.students', [$class]) }}">
        <div class="parent-icon"><i class='lni lni-users'></i></div>
        <div class="menu-title">
          {{ $class->name }} Students
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
@endif
