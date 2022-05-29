<div>
    <x-table class="table-borderless">
        <x-slot name="head"></x-slot>

        <x-slot name="body">
            <x-table.row>
                <x-table.cell><strong>CLASS TEACHER'S COMMENT:</strong></x-table.cell>
                <x-table.cell>  {{ $exam_record->teachers_comment ?: str_repeat('__', 40) }}</x-table.cell>
            </x-table.row>
            <x-table.row>
                <x-table.cell><strong>PRINCIPAL'S COMMENT:</strong></x-table.cell>
                <x-table.cell>  {{ $exam_record->principals_comment ?: str_repeat('__', 40) }}</x-table.cell>
            </x-table.row>
            <x-table.row>
                <x-table.cell><strong>NEXT TERM BEGINS:</strong></x-table.cell>
                <x-table.cell>{{ date('l\, jS F\, Y', strtotime($s['term_begins'])) }}</x-table.cell>
            </x-table.row>
            {{--      <x-table.row>--}}
            {{--        <x-table.cell><strong>NEXT TERM FEES:</strong></x-table.cell>--}}
            {{--        <x-table.cell><del style="text-decoration-style: double">N</del>{{ $s['next_term_fees_'.strtolower($ct)] }}</x-table.cell>--}}
            {{--      </x-table.row>--}}
        </x-slot>
    </x-table>
</div>
