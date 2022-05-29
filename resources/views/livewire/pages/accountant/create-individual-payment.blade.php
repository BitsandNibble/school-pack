<div>
    <x-card-with-header>
        <x-slot name="header">
            <h6 class="fw-bold my-auto">Create Individual Payment</h6>
        </x-slot>

        <div class="row">
            <div class="col-md-6 mb-2">
                <x-label>Session <span class="text-danger">*</span></x-label>
                <x-select wire:model="session">
                    @foreach(all_sessions() as $sess)
                        <option value="{{ $sess }}">{{ $sess }}</option>
                    @endforeach
                </x-select>
                <x-input-error for="session" />
            </div>

            <div class="col-md-6 mb-2">
                <x-label>Term <span class="text-danger">*</span></x-label>
                <x-select wire:model.defer="term_id">
                    @if(count($terms) > 0)
                        @foreach($terms as $t)
                            <option value="{{ $t->id }}">{{ $t->name }}</option>
                        @endforeach
                    @endif
                </x-select>
                <x-input-error for="term_id" />
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-2">
                <x-label>Title <span class="text-danger">*</span></x-label>
                <x-input type="text" wire:model.defer="payment.title" placeholder="E.g School Fees" />
                <x-input-error for="payment.title" />
            </div>

            <div class="col-md-6 mb-2">
                <x-label>Class</x-label>
                <x-select wire:model="class_id">
                    @if(count($classes) > 0)
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    @endif
                </x-select>
                <x-input-error for="class_id" />
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-2">
                <x-label>Student</x-label>
                <x-select wire:model.defer="student_id">
                    @if(count($students) > 0)
                        @foreach($students as $st)
                            <option value="{{ $st->id }}">{{ $st->fullname }}</option>
                        @endforeach
                    @endif
                </x-select>
                <x-input-error for="student_id" />
            </div>

            <div class="col-md-6 mb-2">
                <x-label>Payment Method</x-label>
                <x-select wire:model.defer="payment.method">
                    <option value="cash" selected>Cash</option>
                    <option value="online" disabled>Online</option>
                </x-select>
                <x-input-error for="payment.method" />
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-2">
                <x-label>Amount(N) <span class="text-danger">*</span></x-label>
                <x-input type="text" wire:model.defer="payment.amount" />
                <x-input-error for="payment.amount" />
            </div>

            <div class="col-md-6 mb-2">
                <x-label>Description</x-label>
                <x-textarea placeholder="" wire:model.defer="payment.description"></x-textarea>
                <x-input-error for="payment.description" />

                <div class="mt-2">
                    <x-button class="float-end" value="submit" wire:click.prevent="store">Submit</x-button>
                </div>
            </div>
        </div>
    </x-card-with-header>
    <x-spinner />
</div>