<div>
  <x-breadcrumb>
    Payments
    <li class="breadcrumb-item active" aria-current="page">Debtors</li>
  </x-breadcrumb>

  <x-card>
    <div class="row d-flex justify-content-center text-center">
      <div class="col-6">
        <x-label for="year" class="fw-bolder">Select Class</x-label>
        <x-select id="year" class="mb-2" wire:model.defer="selected_year">
          @foreach($years as $year)
            <option value="{{ $year->year }}" selected>{{ $year->year }}</option>
          @endforeach
        </x-select>
        <x-input-error for="class" />

        <x-button class="mt-2" wire:click.prevent="submit">Submit</x-button>
      </div>
    </div>
  </x-card>
  <x-spinner />

  @if($selected_year)
    <x-card-with-header>
      <x-slot name="header">
        <h6 class="fw-bold my-auto">Debtors</h6>
      </x-slot>

      @foreach($classes as $class)
        <h5>{{ $class->name }}</h5>
        <x-responsive-table>
          <thead>
            <tr>
              <th>S/N</th>
              <th>Name</th>
              <th>Amount</th>
              <th>Balance</th>
              <th>Name</th>
              <th>Description</th>
            </tr>
          </thead>

          <tbody>
            <tr>
              @foreach($debtors->sortby('student.class_room_id') as $d)
                @if($class->name === $d->student->class_room->name)
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $d->student->fullname }}</td>
                  <td>{{ $d->payment->amount }}</td>
                  <td>{{ $d->balance ?: $d->payment->amount  }}</td>
                  <td>{{ $d->payment->title }}</td>
                  <td>{{ $d->payment->description }}</td>
                @endif
            </tr>
            @endforeach
          </tbody>
        </x-responsive-table>
        <br>
      @endforeach
    </x-card-with-header>
  @endif

  @push('scripts')
    <script>
        $(document).ready(function () {
            $(".wrapper").addClass("toggled");
            $(".sidebar-wrapper").hover(function () {
                $(".wrapper").addClass("sidebar-hovered");
            }, function () {
                $(".wrapper").removeClass("sidebar-hovered");
            })
        });
    </script>
  @endpush
</div>