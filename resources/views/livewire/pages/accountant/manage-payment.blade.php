<div>
  <x-breadcrumb>
    Payments
    <li class="breadcrumb-item active" aria-current="page">Manage Payments</li>
  </x-breadcrumb>

  <x-card>
    <div class="row d-flex justify-content-center text-center">
      <div class="col-6">
        <x-label for="select_year" class="fw-bolder">Select Session/Year</x-label>
        <x-select id="select_year" class="mb-2" wire:model.defer="session_year">
          @foreach($years as $year)
            <option value="{{ $year->year }}" selected>{{ $year->year }}</option>
          @endforeach
        </x-select>
        <x-input-error for="session_year" />

        <x-button class="mt-2" wire:click.prevent="submit">Submit</x-button>
      </div>
    </div>
  </x-card>

  <x-spinner />

  @if($session_year)
    <x-card-with-header>
      <x-slot name="header">
        <h6 class="fw-bold my-auto">Manage Payments for {{ $session_year }}</h6>
      </x-slot>


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
          <x-responsive-table>
            <thead>
              <tr>
                <th>S/N</th>
                <th>Title</th>
                <th>Amount</th>
                <th>Ref_No</th>
                <th>Class</th>
                <th>Method</th>
                <th>Description</th>
                <th></th>
              </tr>
            </thead>

            <tbody>
              @forelse($general as $gen)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $gen->title }}</td>
                  <td>{{ $gen->amount }}</td>
                  <td>{{ $gen->ref_no }}</td>
                  <td>{{ $gen->class_room->name }}</td>
                  <td>{{ $gen->method }}</td>
                  <td>{{ $gen->description }}</td>
                  <td>
                    <x-button class="px-0" wire:click="edit({{ $gen->id }})" value="" data-bs-toggle="modal"
                              data-bs-target="#editGeneralPaymentModal">
                      <i class="bx bxs-pen"></i>
                    </x-button>
                    <x-button class="px-0" value="" wire:click="openDeleteModal({{ $gen->id }})"
                              data-bs-toggle="modal" data-bs-target="#deleteModal">
                      <i class="bx bxs-trash-alt"></i>
                    </x-button>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="8" align="center">No record found</td>
                </tr>
              @endforelse
            </tbody>
          </x-responsive-table>
        </div>

        <div class="tab-pane fade" id="individual" role="tabpanel">
          <x-responsive-table>
            <thead>
              <tr>
                <th>S/N</th>
                <th>Title</th>
                <th>Amount</th>
                <th>Ref_No</th>
                <th>Class</th>
                <th>Student</th>
                <th>Method</th>
                <th>Description</th>
                <th></th>
              </tr>
            </thead>

            <tbody>
              @forelse($individual as $ind)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $ind->title }}</td>
                  <td>{{ $ind->amount }}</td>
                  <td>{{ $ind->ref_no }}</td>
                  <td>{{ $ind->class_room->name }}</td>
                  <td>{{ $ind->student->fullname }}</td>
                  <td>{{ $ind->method }}</td>
                  <td>{{ $ind->description }}</td>
                  <td>
                    <x-button class="px-0" wire:click="edit({{ $ind->id }})" value="" data-bs-toggle="modal"
                              data-bs-target="#editIndividualPaymentModal">
                      <i class="bx bxs-pen"></i>
                    </x-button>
                    <x-button class="px-0" value="" wire:click="openDeleteModal({{ $ind->id }})"
                              data-bs-toggle="modal" data-bs-target="#deleteModal">
                      <i class="bx bxs-trash-alt"></i>
                    </x-button>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="8" align="center">No record found</td>
                </tr>
              @endforelse
            </tbody>
          </x-responsive-table>
        </div>
      </div>
    </x-card-with-header>

    <x-confirmation-modal id="editGeneralPaymentModal">
      <x-slot name="title">Edit General Payment</x-slot>

      <x-slot name="content">
        <div class="col-md-6 mb-2">
          <x-label>Title <span class="text-danger">*</span></x-label>
          <x-input type="text" wire:model.defer="payment.title" placeholder="E.g School Fees" />
          <x-input-error for="payment.title" />
        </div>

        <div class="col-md-6 mb-2">
          <x-label>Class</x-label>
          <x-select wire:model.defer="payment.class_room_id">
            <option selected value="NULL">All Classes</option>
            @foreach($classes as $class)
              <option value="{{ $class->id }}">{{ $class->name }}</option>
            @endforeach
          </x-select>
        </div>

        <div class="col-md-6 mb-2">
          <x-label>Payment Method</x-label>
          <x-select wire:model.defer="payment.method">
            <option value="cash" selected>Cash</option>
            <option value="online" disabled>Online</option>
          </x-select>
        </div>

        <div class="col-md-6 mb-2">
          <x-label>Amount(N) <span class="text-danger">*</span></x-label>
          <x-input type="text" wire:model.defer="payment.amount" />
          <x-input-error for="payment.amount" />
        </div>

        <div class="col-md-6 mb-2">
          <x-label>Description</x-label>
          <x-textarea placeholder="" wire:model.defer="payment.description"></x-textarea>
          <x-input-error for="payment.description" />
        </div>
      </x-slot>

      <x-slot name="footer">
        <x-button value="dark" wire:click="cancel">Close</x-button>
        <x-button value="submit" wire:click.prevent="store">Update</x-button>
      </x-slot>
    </x-confirmation-modal>

    <x-confirmation-modal id="editIndividualPaymentModal">
      <x-slot name="title">Edit Individual Payment</x-slot>

      <x-slot name="content">
        <div class="col-md-6 mb-2">
          <x-label>Title <span class="text-danger">*</span></x-label>
          <x-input type="text" wire:model.defer="payment.title" placeholder="E.g School Fees" />
          <x-input-error for="payment.title" />
        </div>

        <div class="col-md-6 mb-2">
          <x-label>Class</x-label>
          <x-select wire:model="payment.class_room_id">
            <option selected value="NULL">All Classes</option>
            @foreach($classes as $class)
              <option value="{{ $class->id }}">{{ $class->name }}</option>
            @endforeach
          </x-select>
        </div>

        <div class="col-md-6 mb-2">
          <x-label>Student</x-label>
          <x-select wire:model.defer="payment.student_id">
            @if(count($students) > 0)
              @foreach($students as $st)
                <option value="{{ $st->id }}">{{ $st->fullname }}</option>
              @endforeach
            @endif
          </x-select>
        </div>

        <div class="col-md-6 mb-2">
          <x-label>Payment Method</x-label>
          <x-select wire:model.defer="payment.method">
            <option value="cash" selected>Cash</option>
            <option value="online" disabled>Online</option>
          </x-select>
        </div>

        <div class="col-md-6 mb-2">
          <x-label>Amount(N) <span class="text-danger">*</span></x-label>
          <x-input type="text" wire:model.defer="payment.amount" />
          <x-input-error for="payment.amount" />
        </div>

        <div class="col-md-6 mb-2">
          <x-label>Description</x-label>
          <x-textarea placeholder="" wire:model.defer="payment.description"></x-textarea>
          <x-input-error for="payment.description" />
        </div>
      </x-slot>

      <x-slot name="footer">
        <x-button value="dark" wire:click="cancel">Close</x-button>
        <x-button value="submit" wire:click.prevent="store">Update</x-button>
      </x-slot>
    </x-confirmation-modal>

    <x-confirmation-modal id="deleteModal">
      <x-slot name="title">Delete Payment</x-slot>

      <x-slot name="content">
        Are you sure you want to delete this payment?
      </x-slot>

      <x-slot name="footer">
        <x-button value="dark" wire:click="cancel">Cancel</x-button>
        <x-button value="danger" wire:click.prevent="delete({{ $deleting }})">Delete</x-button>
      </x-slot>
    </x-confirmation-modal>
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
