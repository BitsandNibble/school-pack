<div>
  <div class="row">
    <div class="col-md-6">
      <x-card-with-header>
        <x-slot name="header">
          <h6 class="fw-bold my-auto text-center">BEHAVIOURS</h6>
        </x-slot>

        @foreach($skills->where('skill_type', 'AF') as $index => $af_skill)
          <div class="row mb-3">
            <x-label for="af" class="col-md-6">{{ $af_skill->name }}</x-label>
            <div class="col-md-6">
              <x-select id="af" wire:model.defer="af.{{ $index }}">
                @for($i=1; $i<=5; $i++)
                  <option value="{{ $i }}">{{ $i }}</option>
                @endfor
              </x-select>
            </div>
          </div>
        @endforeach

        <x-button wire:click.prevent="store('af')" class="float-end mt-4">Submit</x-button>
      </x-card-with-header>
    </div>

    <div class="col-md-6">
      <x-card-with-header>
        <x-slot name="header">
          <h6 class="fw-bold my-auto text-center">SKILLS</h6>
        </x-slot>

        @foreach($skills->where('skill_type', 'PS') as $index => $ps_skill)
          <div class="row mb-3">
            <x-label for="ps" class="col-md-6">{{ $ps_skill->name }}</x-label>
            <div class="col-md-6">
              <x-select id="ps" wire:model.defer="ps.{{ $index }}">
                @for($i=1; $i<=5; $i++)
                  <option value="{{ $i }}">{{ $i }}</option>
                @endfor
              </x-select>
            </div>
          </div>
        @endforeach

        <x-button wire:click.prevent="store('ps')" class="float-end mt-4">Submit</x-button>
      </x-card-with-header>
    </div>
  </div>
</div>
