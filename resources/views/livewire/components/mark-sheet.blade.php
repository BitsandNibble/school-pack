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
        <thead>
          <tr>
            <th>S/N</th>
            <th>Photo</th>
            <th>Name</th>
            <th>Adm. No</th>
            <th></th>
          </tr>
        </thead>

        <tbody>
          @forelse($students as $st)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td></td>
              <td>{{ $st->fullname }}</td>
              <td>{{ $st->school_id }}</td>
              <td>
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
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="text-center">No record found</td>
            </tr>
          @endforelse
        </tbody>
      </x-responsive-table>

    </x-card>
  @endif
</div>