<div>
  <x-breadcrumb>
    Results
    <li class="breadcrumb-item active" aria-current="page">Mark Sheet</li>
  </x-breadcrumb>

  <x-card>
    <div class="row">
      <div class="col-md-4 mb-2">
        <x-label for="term">Session</x-label>
        <x-select id="term" wire:model="session">
          @foreach($sessions as $sess)
            <option value="{{ $sess->year }}">{{ $sess->year }}</option>
          @endforeach
        </x-select>
        <x-input-error for="session" />
      </div>

      <div class="col-md-4 mb-2">
        <x-label for="class">Class</x-label>
        <x-select id="class" wire:model="class_id">
          @if(count($classes) > 0)
            @foreach($classes as $class)
              <option value="{{ $class->class_room->id }}">{{ $class->class_room->name }}</option>
            @endforeach
          @endif
        </x-select>
        <x-input-error for="class_id" />
      </div>

      <div class="col-md-4 mb-2">
        <x-label for="section">Section</x-label>
        <x-select id="section" wire:model.defer="section_id">
          @if(count($sections) > 0)
            @foreach($sections as $section)
              <option value="{{ $section->id }}">{{ $section->name }}</option>
            @endforeach
          @endif
        </x-select>
        <x-input-error for="section_id" />
      </div>

      <div class="d-grid gap-2">
        <x-button wire:click.prevent="view">View Mark Sheet</x-button>
      </div>
    </div>
  </x-card>

  <x-spinner />

  @if($selected)
    <x-card>
      <x-responsive-table>
        <x-slot name="head">
          <x-table.heading>S/N</x-table.heading>
          <x-table.heading>Photo</x-table.heading>
          <x-table.heading>Name</x-table.heading>
          <x-table.heading>Adm. No</x-table.heading>
          <x-table.heading></x-table.heading>
        </x-slot>

        <x-slot name="body">
          @forelse($students as $st)
            <x-table.row>
              <x-table.cell>{{ $loop->iteration }}</x-table.cell>
              <x-table.cell></x-table.cell>
              <x-table.cell>{{ $st->fullname }}</x-table.cell>
              <x-table.cell>{{ $st->school_id }}</x-table.cell>
              <x-table.cell>
                <div class="dropdown">
                  <x-button class="dropdown-toggle" value="danger" data-bs-toggle="dropdown" aria-expanded="false">
                    View Marksheet
                  </x-button>
                  <ul class="dropdown-menu">
                    @foreach($marks->where('year', $session)->where('student_id', $st->id)->unique('term') as $term)
                      <li><a class="dropdown-item" target="_blank"
                             href="{{ route('result.marksheet.show', [$st->id, $session, $term->term->id]) }}">
                          {{ $term->term->name }}</a>
                      </li>
                    @endforeach
                  </ul>
                </div>
              </x-table.cell>
            </x-table.row>
          @empty
            <x-table.row>
              <x-table.cell colspan="5" class="text-center">No record found</x-table.cell>
            </x-table.row>
          @endforelse
        </x-slot>
      </x-responsive-table>

    </x-card>
  @endif
</div>