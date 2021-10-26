<div>
  @if($students)
    <x-flash />

    <x-card-with-header>
      <x-slot name="header">
        <h5 class="fw-bold my-auto">Promote Students From <span
              class="text-danger">{{ $class->where('id', $from_class)->first()->name . ' ' . $section->where('id', $from_section)->first()->name }}</span>
          TO
          <span
              class="text-success">{{ $class->where('id', $to_class)->first()->name . ' ' . $section->where('id', $to_section)->first()->name }}</span>
        </h5>
      </x-slot>

      <div class="table-responsive">
        <table class="table table-striped table-sm" style="width:100%">
          <thead>
            <tr>
              <th>S/N</th>
              <th>Name</th>
              <th>Current Session</th>
              <th></th>
            </tr>
          </thead>

          <tbody>
            @forelse($students as $s)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $s->fullname ?? '' }}</td>
                <td>{{ \App\Helpers\SP::getSetting('current_session') ?? '' }}</td>
                <td>
                  <x-select class="form-select-sm" wire:model.defer="decision">
                    <option value="P">Promote</option>
                    <option value="D">Don't Promote</option>
                    <option value="G">Graduate</option>
                  </x-select>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="4" class="text-center">No record found</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="d-block mb-2 text-center">
        <x-button wire:click.prevent="promote"><i class="bx bxs-arrow-to-top"></i>Promote Students
        </x-button>
      </div>
    </x-card-with-header>
  @endif
</div>