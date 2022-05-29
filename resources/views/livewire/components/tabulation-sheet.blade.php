<div>
    <x-breadcrumb>
        Results
        <li class="breadcrumb-item active" aria-current="page">Tabulation Sheet</li>
    </x-breadcrumb>

    <x-card>
        <div class="row">
            <div class="col-md-4 mb-2">
                <x-label for="term">Term</x-label>
                <x-select id="term" wire:model="term_id">
                    @foreach($terms as $term)
                        <option value="{{ $term->id }}" {{ is_term_locked($term) }}>{{ $term->name }}
                            ({{ $term->session }})
                        </option>
                    @endforeach
                </x-select>
                <x-input-error for="term_id" />
            </div>

            <div class="col-md-4 mb-2">
                <x-label for="class">Class</x-label>
                <x-select id="class" wire:model.defer="class_id">
                    @if(count($classes) > 0)
                        @foreach($classes as $class)
                            @auth('principal')
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endauth

                            @auth('teacher')
                                <option value="{{ $class->class_room_id }}">{{ $class->class_room->name }}</option>
                            @endauth
                        @endforeach
                    @endif
                </x-select>
                <x-input-error for="class_id" />
            </div>

            {{--      <div class="col-md-4 mb-2">--}}
            {{--        <x-label for="subject">Subject</x-label>--}}
            {{--        <x-select id="subject" wire:model.defer="subject_id">--}}
            {{--          @if(count($subjects) > 0)--}}
            {{--            @foreach($subjects as $subject)--}}
            {{--              <option value="{{ $subject->subject->id }}">{{ $subject->subject->name }}</option>--}}
            {{--            @endforeach--}}
            {{--          @endif--}}
            {{--        </x-select>--}}
            {{--        <x-input-error for="subject_id" />--}}
            {{--      </div>--}}

            <div class="d-grid gap-2">
                <x-button wire:click.prevent="view">View Sheet</x-button>
            </div>
        </div>
    </x-card>

    <x-spinner />

    @if($class_id)
        <x-card>
            <div class="fw-bolder mb-2">
                Tabulation Sheet for {{ $class_name }} - {{ $term_name }} @if($class_id)
                    ({{ $selected_year }})
                @endif
            </div>

            <x-responsive-table>
                <x-slot name="head">
                    <x-table.heading>S/N</x-table.heading>
                    <x-table.heading>Name</x-table.heading>
                    @foreach($subjects as $sub)
                        <x-table.heading>{{ $sub->subject->slug ?:  $sub->subject->name }}</x-table.heading>
                    @endforeach
                    <x-table.heading class="text-danger">Total</x-table.heading>
                    <x-table.heading class="text-primary">Average</x-table.heading>
                    <x-table.heading class="text-info">Position</x-table.heading>
                </x-slot>

                <x-slot name="body">
                    @forelse($students as $s)
                        <x-table.row>
                            <x-table.cell>{{ $loop->iteration }}</x-table.cell>
                            <x-table.cell>{{ $s->student->fullname }}</x-table.cell>
                            @foreach($subjects as $sub)
                                <x-table.cell>{{ $marks->where('student_id', $s->student_id)->where('subject_id', $sub->subject_id)->first()->total_score ?? '-' }}</x-table.cell>
                            @endforeach
                            <x-table.cell
                                    class="text-danger">{{ $exam_record->where('student_id', $s->student_id)->first()->total ?? '' }}</x-table.cell>
                            <x-table.cell
                                    class="text-primary">{{ $exam_record->where('student_id', $s->student_id)->first()->average ?? '' }}</x-table.cell>
                            <x-table.cell
                                    class="text-info">{!! get_suffix($exam_record->where('student_id', $s->student_id)->first()->position) ?? '' !!}</x-table.cell>
                        </x-table.row>
                    @empty
                        <x-table.row>
                            <x-table.cell colspan="6" class="text-center">No record found</x-table.cell>
                        </x-table.row>
                    @endforelse
                </x-slot>
            </x-responsive-table>

            <div class="d-block mb-2 text-center">
                <x-button-link target="_blank" href="{{ route('print_tabulation_sheet', [$term_id, $class_id]) }}"><i
                            class="bx bx-printer"></i>Print Tabulation Sheet
                </x-button-link>
            </div>
        </x-card>
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