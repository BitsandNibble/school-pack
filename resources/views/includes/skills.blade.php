<div class="row">
    <div class="col-5">
        <x-table class="table-bordered" style="border: solid 1px">
            <x-slot name="head">
                <x-table.heading>AFFECTIVE SKILLS</x-table.heading>
                <x-table.heading>RATING</x-table.heading>
            </x-slot>

            <x-slot name="body">
                @foreach($skills->where('skill_type', 'AF') as $af)
                    <x-table.row>
                        <x-table.cell>{{ $af->name }}</x-table.cell>
                        <x-table.cell>{{ $exam_record->af ? explode(',', $exam_record->af)[$loop->index] : '-' }}</x-table.cell>
                    </x-table.row>
                @endforeach
            </x-slot>
        </x-table>
    </div>

    <div class="col-5">
        <x-table class="table-bordered" style="border: solid 1px">
            <x-slot name="head">
                <x-table.heading>BEHAVIOUR</x-table.heading>
                <x-table.heading>RATING</x-table.heading>
            </x-slot>

            <x-slot name="body">
                @foreach($skills->where('skill_type', 'PS') as $ps)
                    <x-table.row>
                        <x-table.cell>{{ $ps->name }}</x-table.cell>
                        <x-table.cell>{{ $exam_record->ps ? explode(',', $exam_record->ps)[$loop->index] : '' }}</x-table.cell>
                    </x-table.row>
                @endforeach
            </x-slot>
        </x-table>
    </div>

    <div class="col-2">
        <h6 class="fw-bold text-decoration-underline">KEY</h6>
        <ul class="list-unstyled">
            <li>5 - Excellent</li>
            <li>4 - Very Good</li>
            <li>3 - Good</li>
            <li>2 - Fair</li>
            <li>1 - Poor</li>
        </ul>
    </div>
</div>