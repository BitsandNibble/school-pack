<div>
  <x-breadcrumb>
    Financials
    <li class="breadcrumb-item active" aria-current="page">Student Payments</li>
  </x-breadcrumb>

  <x-card>
    <div class="row d-flex justify-content-center text-center">
      <div class="col-6">
        <x-label for="class" class="fw-bolder">Select Class</x-label>
        <x-select id="class" class="mb-2" wire:model.defer="class">
          @foreach($classes as $cl)
            <option value="{{ $cl->id }}" selected>{{ $cl->name }}</option>
          @endforeach
        </x-select>
        <x-input-error for="class" />

        <x-button class="mt-2" wire:click.prevent="submit">Submit</x-button>
      </div>
    </div>
  </x-card>
  <x-spinner />

  @if($class)
    <x-card>
      <x-responsive-table>
        <x-slot name="head">
          <x-table.heading>S/N</x-table.heading>
          <x-table.heading>Name</x-table.heading>
          <x-table.heading>Adm No</x-table.heading>
          <x-table.heading>Payments</x-table.heading>
        </x-slot>

        <x-slot name="body">
          @forelse($students as $st)
            <x-table.row>
              <x-table.cell>{{ $loop->iteration }}</x-table.cell>
              <x-table.cell>{{ $st->fullname }}</x-table.cell>
              <x-table.cell>{{ $st->school_id }}</x-table.cell>
              <x-table.cell>
                <div class="dropdown">
                  <x-button class="dropdown-toggle" value="danger" data-bs-toggle="dropdown" aria-expanded="false">
                    Manage Payments
                  </x-button>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" target="_blank"
                           href="{{ route('payment.invoice', [$st->id]) }}">
                        All Payments</a>
                    </li>
                    @foreach($payments->where('student_id', $st->id)->pluck('session')->unique() as $session)
                      <li><a class="dropdown-item" target="_blank"
                             href="{{ route('payment.invoice', [$st->id, $session]) }}">
                          {{ $year }}</a>
                      </li>
                    @endforeach
                  </ul>
                </div>
              </x-table.cell>
            </x-table.row>
          @empty
            <x-table.row>
              <x-table.cell colspan="4" align="center">No record found</x-table.cell>
            </x-table.row>
          @endforelse
        </x-slot>
      </x-responsive-table>
    </x-card>
  @endif
</div>
