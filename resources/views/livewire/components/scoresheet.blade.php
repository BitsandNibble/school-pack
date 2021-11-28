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
        <x-slot name="head">
          <x-table.heading>S/N</x-table.heading>
          <x-table.heading>Name</x-table.heading>
          <x-table.heading>Adm. No</x-table.heading>
          <x-table.heading>1st CA ({{ $ca1_limit }})</x-table.heading>
          <x-table.heading>2nd CA ({{ $ca2_limit }})</x-table.heading>
          <x-table.heading>Exam ({{ $exam_limit }})</x-table.heading>
        </x-slot>

        <x-slot name="body">
          @forelse($get_marks as $index => $mark)
            <x-table.row>
              <x-table.cell>{{ $loop->iteration }}</x-table.cell>
              <x-table.cell>{{ $mark->student->fullname }}</x-table.cell>
              <x-table.cell>{{ $mark->student->school_id }}</x-table.cell>

              {{--                CA and exam score--}}
              @unless($showEdit)
                <x-table.cell class="px-5">{{ $mark->ca1 }}</x-table.cell>
                <x-table.cell class="px-5">{{ $mark->ca2 }}</x-table.cell>
                <x-table.cell class="px-5">{{ $mark->exam_score }}</x-table.cell>
              @else
                <x-table.cell class="px-5">
                  <x-input type="number" class="form-control-sm" max="{{ $ca1_limit }}"
                           wire:model.defer="marks.{{ $index }}.ca1" />
                </x-table.cell>
                <x-table.cell class="px-5">
                  <x-input type="number" class="form-control-sm" max="{{ $ca2_limit }}"
                           wire:model.defer="marks.{{ $index }}.ca2" />
                </x-table.cell>
                <x-table.cell class="px-5">
                  <x-input type="number" class="form-control-sm" max="{{ $exam_limit }}"
                           wire:model.defer="marks.{{ $index }}.exam_score" />
                </x-table.cell>
              @endunless
            </x-table.row>
          @empty
            <x-table.row>
              <x-table.cell colspan="6" class="text-center">No record found</x-table.cell>
            </x-table.row>
          @endforelse
        </x-slot>
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