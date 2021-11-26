<div>
  @if($get_marks)
    <x-card>
      <div class="row fw-bolder">
        <div class="col"><p>Subject: {{ $subject }}</p></div>
        <div class="col"><p>Class: {{ $class }}</p></div>
        <div class="col">
          <p>Term: {{ $term->name }} ({{ $term->session }})</p>
        </div>
      </div>

      <x-responsive-table>
        <x-validation-errors />
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
          @forelse($get_marks as $index => $mark)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $mark->student->fullname }}</td>
              <td>{{ $mark->student->school_id }}</td>

              {{--                CA and exam score--}}
              @unless($showEdit)
                <td class="px-5">{{ $mark->ca1 }}</td>
                <td class="px-5">{{ $mark->ca2 }}</td>
                <td class="px-5">{{ $mark->exam_score }}</td>
              @else
                <td class="px-5">
                  <x-input type="number" class="form-control-sm" max="{{ $ca1_limit }}" wire:model.defer="marks.{{ $index }}.ca1" />
                </td>
                <td class="px-5">
                  <x-input type="number" class="form-control-sm" max="{{ $ca2_limit }}" wire:model.defer="marks.{{ $index }}.ca2" />
                </td>
                <td class="px-5">
                  <x-input type="number" class="form-control-sm" max="{{ $exam_limit }}"
                           wire:model.defer="marks.{{ $index }}.exam_score" />
                </td>
              @endunless
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center">No record found</td>
            </tr>
          @endforelse
        </tbody>
      </x-responsive-table>

      <div class="d-block mb-2 float-end">
        {{--        check if exam is locked--}}
        @unless($term->locked)
          <x-button value="dark"
                    wire:click="$toggle('showEdit')">{{ $showEdit ? 'Cancel Edit' : 'Edit Marks' }}</x-button>
          @if($showEdit)
            <x-button wire:click.prevent="store">Update Marks</x-button>
          @endif
        @else
          <sub class="text-danger">Session is locked. Contact admin to unlock before any changes can be made to
            this page</sub>
        @endunless
      </div>
    </x-card>
  @endif
</div>