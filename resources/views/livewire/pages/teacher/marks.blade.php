<div>
  <x-flash />

  <x-card>
    <div class="row fw-bolder">
      <div class="col"><p>Subject: {{ $subject }}</p></div>
      <div class="col"><p>Class: {{ $class }}</p></div>
      <div class="col">
        <p>Exam: {{ $exam }} @if($get_marks) ({{ \App\Helpers\SP::getSetting('current_session') }}) @endif</p>
      </div>
    </div>
    <div class="table-responsive">
      <x-validation-errors />
      <table class="table table-striped table-sm" style="width:100%">
        <thead>
          <tr>
            <th>S/N</th>
            <th>Name</th>
            <th>Adm. No</th>
            <th>1st CA ({{ $ca1_limit }})</th>
            <th>2nd CA ({{ $ca2_limit }})</th>
            <th>Exam ({{ $exam_limit }})</th>
          </tr>
        </thead>

        <tbody>
          @if($get_marks)
            @forelse($get_marks as $mark)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $mark->student->fullname ?? '' }}</td>
                <td>{{ $mark->student->school_id ?? '' }}</td>

                {{--                CA and exam score--}}
                @unless($showEdit)
                  <td class="px-5">{{ $mark->ca1 ?? '' }}</td>
                  <td class="px-5">{{ $mark->ca2 ?? '' }}</td>
                  <td class="px-5">{{ $mark->exam_score ?? '' }}</td>
                @else
                  <td class="px-5">
                    <x-input class="form-control-sm" type="number" wire:model.defer="marks.ca1" />
                  </td>
                  <td class="px-5">
                    <x-input class="form-control-sm" type="number" wire:model.defer="marks.ca2" />
                  </td>
                  <td class="px-5">
                    <x-input class="form-control-sm" type="number" wire:model.defer="marks.exam_score" />
                  </td>
                @endunless
              </tr>
            @empty
              <tr>
                <td colspan="6" class="text-center">No record found</td>
              </tr>
            @endforelse

          @endif
        </tbody>
      </table>
    </div>

      @if($get_marks)
        <div class="d-block mb-2 float-end">
          <x-button value="dark" wire:click="$toggle('showEdit')">{{ $showEdit ? 'Cancel Edit' : 'Edit Marks' }}</x-button>
          <x-button wire:click.prevent="store">Update Marks</x-button>
        </div>
      @endif
  </x-card>
</div>