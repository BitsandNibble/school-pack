<div>
	<x-breadcrumb>
		Results
		<li class="breadcrumb-item active" aria-current="page">Mark Sheet</li>
	</x-breadcrumb>

	<x-card>
		<div class="row">
			<div class="col-md-4 mb-2">
				<x-label for="term">Session</x-label>
				<x-select id="term" wire:model="session">
					@foreach($sessions as $sess)
						<option value="{{ $sess->year }}">{{ $sess->year }}</option>
					@endforeach
				</x-select>
				<x-input-error for="session" />
			</div>

			<div class="col-md-4 mb-2">
				<x-label for="class">Class</x-label>
				<x-select id="class" wire:model="class_id">
					@if(count($classes) > 0)
						@foreach($classes as $class)
							<option value="{{ $class->id }}">{{ $class->name }}</option>
						@endforeach
					@endif
				</x-select>
				<x-input-error for="class_id" />
			</div>

			<div class="col-md-4 mb-2">
				<x-label for="section">Section</x-label>
				<x-select id="section" wire:model.defer="section_id">
					@if(count($sections) > 0)
						@foreach($sections as $section)
							<option value="{{ $section->id }}">{{ $section->name }}</option>
						@endforeach
					@endif
				</x-select>
				<x-input-error for="section_id" />
			</div>

			<div class="d-grid gap-2">
				<x-button wire:click.prevent="view">View Mark Sheet</x-button>
			</div>
		</div>
	</x-card>

	<x-spinner />

	@if($selected)
		<x-card>
			<x-responsive-table>
				<x-slot name="head">
					<x-table.heading>S/N</x-table.heading>
					<x-table.heading>Photo</x-table.heading>
					<x-table.heading>Name</x-table.heading>
					<x-table.heading>Adm. No</x-table.heading>
					<x-table.heading></x-table.heading>
				</x-slot>

				<x-slot name="body">
					@forelse($students as $st)
						<x-table.row>
							<x-table.cell>{{ $loop->iteration }}</x-table.cell>
							<x-table.cell></x-table.cell>
							<x-table.cell>{{ $st->fullname }}</x-table.cell>
							<x-table.cell>{{ $st->school_id }}</x-table.cell>
							<x-table.cell>
								<x-button-link
										href="{{ route('result.marksheet.show', [$st->id, $session, $class_id]) }}"
										value="danger">
									View Marksheet

									<svg width="25px" height="10px" xmlns="http://www.w3.org/2000/svg"
										 viewBox="0 0 448 512">
										<!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
										<path d="M438.6 278.6l-160 160C272.4 444.9 264.2 448 256 448s-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L338.8 288H32C14.33 288 .0016 273.7 .0016 256S14.33 224 32 224h306.8l-105.4-105.4c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l160 160C451.1 245.9 451.1 266.1 438.6 278.6z" />
									</svg>
								</x-button-link>
							</x-table.cell>
						</x-table.row>
					@empty
						<x-table.row>
							<x-table.cell colspan="5" class="text-center">No record found</x-table.cell>
						</x-table.row>
					@endforelse
				</x-slot>
			</x-responsive-table>

		</x-card>
	@endif
</div>