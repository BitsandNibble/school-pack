<div>
    <x-breadcrumb>
        Grading
        <li class="breadcrumb-item active" aria-current="page">Scores</li>
    </x-breadcrumb>

    <x-card>
        <div class="row">
            <div class="col-md-3 mb-2">
                <x-label for="term">Term</x-label>
                <x-select id="term" wire:model="term_id">
                    @foreach ($terms as $term)
                        <option value="{{ $term->id }}" {{ is_term_locked($term) }}>{{ $term->name }}
                            ({{ $term->session }})
                        </option>
                    @endforeach
                </x-select>
                <x-input-error for="term_id" />
            </div>

            <div class="col-md-3 mb-2">
                <x-label for="class">Class</x-label>
                <x-select id="class" wire:model="class_id">
                    @if (count($classes) > 0)
                        @foreach ($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    @endif
                </x-select>
                <x-input-error for="class_id" />
            </div>

            <div class="col-md-3 mb-2">
                <x-label for="class">Section</x-label>
                <x-select id="class" wire:model="section_id">
                    @if (count($sections) > 0)
                        @foreach ($sections as $section)
                            @auth('principal')
                                <option value="{{ $section->id }}">{{ $section->name }}</option>
                            @endauth

                            @auth('teacher')
                                <option value="{{ $section->id }}">{{ $section->name }}</option>
                            @endauth
                        @endforeach
                    @endif
                </x-select>
                <x-input-error for="section_id" />
            </div>

            <div class="col-md-3 mb-2">
                <x-label for="subject">Subject</x-label>
                <x-select id="subject" wire:model.defer="subject_id">
                    @if (count($subjects) > 0)
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                        @endforeach
                    @endif
                </x-select>
                <x-input-error for="subject_id" />
            </div>

            <div class="d-grid gap-2">
                <x-button wire:click.prevent="manage">Manage Mark</x-button>
            </div>
        </div>
    </x-card>

    <livewire:components.scoresheet />

    <x-spinner />

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
</div>
