<x-app-layout>
    <x-breadcrumb>
        Results
        <li class="breadcrumb-item active" aria-current="page">Mark Sheet</li>
        <li class="breadcrumb-item active" aria-current="page">Student Mark Sheet</li>
    </x-breadcrumb>

    <x-card>
        <h5> Student Marksheet for {{ $student->fullname }}
            ({{ $student->class_room->name . ' ' . $student->section->name }})
            ({{ $exam_records->first()->year }})
        </h5>
    </x-card>


    <ul class="nav nav-tabs nav-primary" role="tablist">
        @foreach ($exam_records as $key => $exam_record)
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ $key == 0 ? 'active' : '' }}" data-bs-toggle="tab" role="tab"
                    @if ($key == 0) href="#first" @elseif ($key == 1) href="#second" @else href="#third" @endif
                    aria-selected="true">
                    <div class="d-flex align-items-center">
                        <div class="tab-title">
                            @if ($key == 0)
                                First
                            @elseif ($key == 1)
                                Second
                            @else
                                Third
                            @endif
                            Term
                        </div>
                    </div>
                </a>
            </li>
        @endforeach
    </ul>


    <div class="tab-content py-3">
        @foreach ($exam_records as $key => $exam_record)
            <div class="tab-pane fade {{ $key == 0 ? 'active show' : '' }}"
                @if ($key == 0) id="first" @elseif ($key == 1) id="second" @else id="third" @endif
                role="tabpanel">
                <x-card>
                    <x-responsive-table class="table-bordered text-center">
                        <x-slot name="head">
                            <x-table.heading>S/N</x-table.heading>
                            <x-table.heading>SUBJECTS</x-table.heading>
                            <x-table.heading>CA1 <br> ({{ $ca1_limit }})</x-table.heading>
                            <x-table.heading>CA2 <br> ({{ $ca2_limit }})</x-table.heading>
                            <x-table.heading>EXAM <br> ({{ $exam_limit }})</x-table.heading>
                            <x-table.heading>TOTAL <br> ({{ $total }})</x-table.heading>
                            <x-table.heading>GRADE</x-table.heading>
                            <x-table.heading>SUBJECT <br> POSITION</x-table.heading>
                            <x-table.heading>REMARKS</x-table.heading>
                        </x-slot>

                        <x-slot name="body">
                            @foreach ($marks->where('term_id', $exam_record->term_id) as $mark)
                                <x-table.row>
                                    <x-table.cell>{{ $loop->iteration }}</x-table.cell>
                                    <x-table.cell>{{ $mark->subject->name }}</x-table.cell>
                                    <x-table.cell>{{ $mark->ca1 }}</x-table.cell>
                                    <x-table.cell>{{ $mark->ca2 }}</x-table.cell>
                                    <x-table.cell>{{ $mark->exam_score }}</x-table.cell>
                                    <x-table.cell>{{ $mark->total_score }}</x-table.cell>
                                    <x-table.cell>{{ $mark->grade->name }}</x-table.cell>
                                    <x-table.cell>{!! get_suffix($mark->subject_position) !!}</x-table.cell>
                                    <x-table.cell>{{ $mark->grade->remark }}</x-table.cell>
                                </x-table.row>
                            @endforeach
                            <x-table.row>
                                <x-table.cell colspan="3"><strong>TOTAL SCORES OBTAINED: </strong>
                                    {{ $exam_record->total }}
                                </x-table.cell>
                                <x-table.cell colspan="3"><strong>FINAL AVERAGE: </strong>
                                    {{ $exam_record->average }}
                                </x-table.cell>
                                <x-table.cell colspan="2"><strong>CLASS AVERAGE: </strong>
                                    {{ $exam_record->class_average }}
                                </x-table.cell>
                                <x-table.cell><strong>POSITION: </strong> {!! get_suffix($exam_record->position) !!}</x-table.cell>
                            </x-table.row>
                        </x-slot>

                    </x-responsive-table>

                    <div class="d-block mb-2 text-center">
                        <x-button-link target="_blank"
                            href="{{ route('print_marksheet', [$student->id, $exam_record->term_id, $exam_record->year]) }}">
                            <i class="bx bx-printer"></i>Print Mark Sheet
                        </x-button-link>
                    </div>
                </x-card>
            </div>
        @endforeach
    </div>

    {{-- only show this section to principal and teacher --}}
    @if (auth('principal')->check() || auth('teacher')->check())
        <livewire:components.comment :id="$student->id" :term="$exam_record->term_id" :year="$year" />
        <livewire:components.skills :id="$student->id" :term="$exam_record->term_id" :year="$year" />
    @endif

    @push('scripts')
        <script>
            $(document).ready(function() {
                $(".wrapper").addClass("toggled");
                $(".sidebar-wrapper").hover(function() {
                    $(".wrapper").addClass("sidebar-hovered");
                }, function() {
                    $(".wrapper").removeClass("sidebar-hovered");
                })
            });
        </script>
    @endpush
</x-app-layout>
