<x-app-layout>
    <x-breadcrumb>
        Results
        <li class="breadcrumb-item active" aria-current="page">Mark Sheet</li>
        <li class="breadcrumb-item active" aria-current="page">Student Mark Sheet</li>
    </x-breadcrumb>

    <x-card>
        <h5> Student Marksheet for {{ $student->fullname }}
            ({{ $student->class_room->name . ' ' . $student->section->name }})
        </h5>
    </x-card>

    <x-card>
        <h5 class="mb-4">{{ $exam_record->term->name . ' - ' . $exam_record->year }}</h5>

        <x-responsive-table class="table-bordered text-center">
            {{--        <table class="table table-bordered table-sm mt-4 text-center" style="width:100%; border: 1px solid #000; border-collapse:collapse;">--}}

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
                @foreach($marks as $mark)
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
                    <x-table.cell colspan="3"><strong>TOTAL SCORES OBTAINED: </strong> {{ $exam_record->total }}
                    </x-table.cell>
                    <x-table.cell colspan="3"><strong>FINAL AVERAGE: </strong> {{ $exam_record->average }}
                    </x-table.cell>
                    <x-table.cell colspan="2"><strong>CLASS AVERAGE: </strong> {{ $exam_record->class_average }}
                    </x-table.cell>
                    <x-table.cell><strong>POSITION: </strong> {!! $position !!}</x-table.cell>
                </x-table.row>
            </x-slot>

        </x-responsive-table>

        <div class="d-block mb-2 text-center">
            <x-button-link target="_blank"
                           href="{{ route('print_marksheet', [$student->id, $exam_record->term_id, $exam_record->year]) }}">
                <i
                        class="bx bx-printer"></i>Print Mark Sheet
            </x-button-link>
        </div>
    </x-card>

    @auth('student')
    @else
        <livewire:components.comment :id="$student->id" />
        <livewire:components.skills :id="$student->id" :year="$year" />
    @endauth

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
</x-app-layout>