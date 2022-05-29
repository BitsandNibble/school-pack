<div>
    <x-breadcrumb>
        Financials
        <li class="breadcrumb-item active" aria-current="page">Create Payment</li>
    </x-breadcrumb>

    <ul class="nav nav-tabs nav-primary" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" data-bs-toggle="tab" href="#general" role="tab" aria-selected="true">
                <div class="d-flex align-items-center">
                    <div class="tab-title">General Payment</div>
                </div>
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" data-bs-toggle="tab" href="#individual" role="tab" aria-selected="false">
                <div class="d-flex align-items-center">
                    <div class="tab-title">Individual Payment</div>
                </div>
            </a>
        </li>
    </ul>

    <div class="tab-content py-3">
        <div class="tab-pane fade active show" id="general" role="tabpanel">
            <x-card-with-header>
                <x-slot name="header">
                    <h6 class="fw-bold my-auto">Create General Payment</h6>
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
                        <x-label>Class <span class="text-danger">*</span></x-label>
                        <x-select wire:model.defer="payment.class">
                            @if(count($classes) > 0)
                                <option selected value="NULL">ALL CLASSES</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            @endif
                        </x-select>
                        <x-input-error for="payment.class" />
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-2">
                        <x-label>Payment Method</x-label>
                        <x-select wire:model.defer="payment.method">
                            <option value="cash" selected>Cash</option>
                            <option value="online" disabled>Online</option>
                        </x-select>
                        <x-input-error for="payment.method" />
                    </div>

                    <div class="col-md-6 mb-2">
                        <x-label>Amount(N) <span class="text-danger">*</span></x-label>
                        <x-input type="text" wire:model.defer="payment.amount" />
                        <x-input-error for="payment.amount" />
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6"></div>
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
        </div>

        <x-spinner />

        <div class="tab-pane fade" id="individual" role="tabpanel">
            <livewire:pages.accountant.create-individual-payment />
        </div>
    </div>

</div>