<div>
  <x-breadcrumb>
    Financials
    <li class="breadcrumb-item active" aria-current="page">Debtors</li>
  </x-breadcrumb>

  <x-card>
    <div class="row">
      <div class="col-md-6">
        <x-label for="session" class="fw-bolder">Select Session</x-label>
        <x-select id="session" class="mb-2" wire:model="selected_session">
          @foreach($sessions as $sess)
            <option value="{{ $sess->session }}" selected>{{ $sess->session }}</option>
          @endforeach
        </x-select>
        <x-input-error for="selected_session" />
      </div>

      <div class="col-md-6">
        <x-label for="term" class="fw-bolder">Select Term</x-label>
        <x-select id="term" class="mb-2" wire:model.defer="selected_term">
          @if(count($terms) > 0)
            @foreach($terms as $term)
              <option value="{{ $term->id }}" selected>{{ $term->name }}</option>
            @endforeach
          @endif
        </x-select>
        <x-input-error for="selected_term" />
      </div>

      <div class="d-grid gap-2">
        <x-button class="mt-2" wire:click.prevent="submit">Submit</x-button>
      </div>
    </div>
  </x-card>
  <x-spinner />

  @if($selected_term)
    <x-card-with-header>
      <x-slot name="header">
        <h6 class="fw-bold my-auto">Debtors</h6>
      </x-slot>

      @foreach($classes as $class)
        <h5>{{ $class->name }}</h5>
        <x-responsive-table>
          <x-slot name="head">
            <x-table.heading>S/N</x-table.heading>
            <x-table.heading>Name</x-table.heading>
            <x-table.heading>Amount</x-table.heading>
            <x-table.heading>Balance</x-table.heading>
            <x-table.heading>Name</x-table.heading>
            <x-table.heading>Description</x-table.heading>
          </x-slot>

          <x-slot name="body">
            @forelse($debtors->sortby('student.class_room_id') as $d)
              <x-table.row>
                @if($class->name === $d->student->class_room->name)
                  <x-table.cell>{{ $loop->iteration }}</x-table.cell>
                  <x-table.cell>{{ $d->student->fullname }}</x-table.cell>
                  <x-table.cell class="text-danger">{{ $d->payment->amount }}</x-table.cell>
                  <x-table.cell class="text-dark fw-bolder">{{ $d->balance ?: $d->payment->amount  }}</x-table.cell>
                  <x-table.cell>{{ $d->payment->title }}</x-table.cell>
                  <x-table.cell>{{ $d->payment->description }}</x-table.cell>
                @endif
              </x-table.row>
            @empty
              <x-table.row>
                <x-table.cell colspan="6" class="text-center">No record found</x-table.cell>
              </x-table.row>
            @endforelse
          </x-slot>
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