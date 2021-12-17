<div>
  <h5 class="mt-5">Other Settings</h5>
  <x-card class="border-0 border-dark border-5 border-end">
    <span class="fw-bold">Lock/Unlock Exams</span>

    @foreach($terms as $term)
      <div class="row mb-2">
        <div class="col-md-4">
          {{ $loop->iteration. '.' }}
          {{ $term->name }} ({{ $term->session }})
        </div>

        <div class="col-md-2">
          <x-button value="" wire:click="unlock({{ $term->id }})">
            @if ($term->locked)
              <span class="badge rounded-pill bg-warning text-dark">Locked</span>
            @else
              <span class="badge rounded-pill bg-success">Unlocked</span>
            @endif
          </x-button>
        </div>
      </div>
    @endforeach
  </x-card>

  <x-spinner />
</div>