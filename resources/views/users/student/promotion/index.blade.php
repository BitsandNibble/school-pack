<x-app-layout>
  <x-breadcrumb>
    Students
    <li class="breadcrumb-item active" aria-current="page">Promote Students</li>
  </x-breadcrumb>
  <x-flash />

  <x-card-with-header>
    <x-slot name="header">
      <h5 class="fw-bold my-auto">Student Promotion From <span class="text-danger">{{ $old_year }}</span> TO
        <span class="text-success">{{ $new_year }}</span> Session</h5>
    </x-slot>

    <div>
      {{--      @include('users.student.promotion.selector')--}}
    </div>
  </x-card-with-header>

  @if($selected)
    <x-card-with-header>
      <x-slot name="header">
        <h5 class="card-title font-weight-bold">Promote Students From <span
              class="text-teal">{{ $class_rooms->where('id', $fc)->first()->name.' '.$sections->where('id', $fs)->first()->name }}</span>
          TO <span
              class="text-purple">{{ $my_classes->where('id', $tc)->first()->name.' '.$sections->where('id', $ts)->first()->name }}</span>
        </h5>
      </x-slot>

      <div>
        {{--        @include('users.student.promotion.promote')--}}
      </div>
    </x-card-with-header>
  @endif

</x-app-layout>
