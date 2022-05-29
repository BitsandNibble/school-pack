<div>
    <x-breadcrumb>
        Students
        <li class="breadcrumb-item active" aria-current="page">Manage Promotions</li>
    </x-breadcrumb>

    <x-card-with-header>
        <x-slot name="header">
            <h5 class="fw-bold my-auto">Students Who Were Promoted From <span class="text-danger">{{ $old_year }}</span>
                TO
                <span class="text-success">{{ $new_year }}</span> Session</h5>
        </x-slot>

        <x-responsive-table>
            <x-slot name="head">
                <x-table.heading>S/N</x-table.heading>
                <x-table.heading>Name</x-table.heading>
                <x-table.heading>From Class</x-table.heading>
                <x-table.heading>To Class</x-table.heading>
                <x-table.heading>Status</x-table.heading>
                <x-table.heading></x-table.heading>
            </x-slot>

            <x-slot name="body">
                @forelse($promotions as $promotion)
                    <x-table.row>
                        <x-table.cell>{{ $loop->iteration }}</x-table.cell>
                        <x-table.cell>{{ $promotion->student->fullname }}</x-table.cell>
                        <x-table.cell>{{ $promotion->fc->name . ' ' . $promotion->fs->name }}</x-table.cell>
                        <x-table.cell>{{ $promotion->tc->name . ' ' . $promotion->ts->name }}</x-table.cell>
                        <x-table.cell>{{ $promotion->status }}</x-table.cell>
                        <x-table.cell></x-table.cell>
                    </x-table.row>
                @empty
                    <x-table.row>
                        <x-table.cell colspan="6" class="text-center">No record found</x-table.cell>
                    </x-table.row>
                @endforelse
            </x-slot>
        </x-responsive-table>

    </x-card-with-header>
</div>