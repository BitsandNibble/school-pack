<div>
  <x-breadcrumb>
    Financials
    <li class="breadcrumb-item active" aria-current="page">Manage Payments</li>
  </x-breadcrumb>

  <x-card>
    <div class="row">
      <div class="col-md-6">
        <x-label for="session" class="fw-bolder">Select Session</x-label>
        <x-select id="session" class="mb-2" wire:model="selected_session">
          @foreach(all_sessions()  as $sess)
            <option value="{{ $sess }}" selected>{{ $sess }}</option>
          @endforeach
        </x-select>
        <x-input-error for="selected_session" />
      </div>

      <div class="col-md-6">
        <x-label for="term" class="fw-bolder">Select Term</x-label>
        <x-select id="term" class="mb-2" wire:model.defer="selected_term">
          @if(count($terms) > 0)
            @foreach($terms as $term)
              <option value="{{ $term->id }}" selected>{{ $term->name }}</option>
            @endforeach
          @endif
        </x-select>
        <x-input-error for="selected_term" />
      </div>

      <div class="d-grid gap-2">
        <x-button class="mt-2" wire:click.prevent="submit">Submit</x-button>
      </div>
    </div>
  </x-card>

  <x-spinner />

  @if($selected_term)
    <x-card-with-header>
      <x-slot name="header">
        <div class="ms-auto d-flex justify-content-between">
          <h6 class="fw-bold my-auto">Manage Payments for {{ $term_name }} ({{ $selected_session }})</h6>
          @if ($selected)
            <x-dropdown class="me-3">
              <x-slot name="title">Bulk Actions</x-slot>

              <li>
                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#deleteSelectedModal" href="#">
                  <i class="bx bxs-trash"></i>
                  Delete
                </a>
              </li>
              <li><a class="dropdown-item" href="#">Archive</a></li>
              <li><a class="dropdown-item" href="#">Export</a></li>
              {{-- <x-button value="success" wire:click="exportSelected" class="float-end">Export</x-button> --}}
            </x-dropdown>
          @endif
        </div>
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
                <th class="pe-0" style="width: 30px">
                  <x-checked-input type="checkbox" wire:model="selectPage" />
                </th>
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
              @if ($selectPage)
                <tr class="bg-gradient-lush">
                  <td colspan="9">
                    @unless($selectAll)
                      <div>
                        You have selected <strong>{{ $general->count() }}</strong> payment(s)
                        @if ($general->count() !== $total), do you want to select
                        all
                        <strong>{{ $total }}</strong>?
                        <x-button-link wire:click="selectAll">Select All</x-button-link>
                        @endif
                      </div>
                    @else
                      You have selected all <strong>{{ $total }}</strong> payments.
                    @endunless
                  </td>
                </tr>
              @endif

              @forelse($general as $gen)
                <tr>
                  <td class="pe-0">
                    <x-checked-input type="checkbox" wire:model="selected" value="{{ $gen->id }}" />
                  </td>
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
                  <td colspan="9" align="center">No record found</td>
                </tr>
              @endforelse
            </tbody>
          </x-responsive-table>
        </div>

        <div class="tab-pane fade" id="individual" role="tabpanel">
          <x-responsive-table>
            <thead>
              <tr>
                <th class="pe-0" style="width: 30px">
                  <x-checked-input type="checkbox" wire:model="selectPage" />
                </th>
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
              @if ($selectPage)
                <tr class="bg-gradient-lush">
                  <td colspan="9">
                    @unless($selectAll)
                      <div>
                        You have selected <strong>{{ $individual->count() }}</strong> payment(s)
                        @if ($individual->count() !== $total), do you want to select
                        all
                        <strong>{{ $total }}</strong>?
                        <x-button-link wire:click="selectAll">Select All</x-button-link>
                        @endif
                      </div>
                    @else
                      You have selected all <strong>{{ $total }}</strong> payments.
                    @endunless
                  </td>
                </tr>
              @endif

              @forelse($individual as $ind)
                <tr>
                  <td class="pe-0">
                    <x-checked-input type="checkbox" wire:model="selected" value="{{ $ind->id }}" />
                  </td>
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

    <x-modal id="editGeneralPaymentModal">
      <x-slot name="title">Edit General Payment</x-slot>

      <x-slot name="content">
        <div class="row">
          <div class="col-md-6 mb-2">
            <x-label>Session <span class="text-danger">*</span></x-label>
            <x-select wire:model="payment.session">
              @foreach(all_sessions() as $sess)
                <option value="{{ $sess }}">{{ $sess }}</option>
              @endforeach
            </x-select>
            <x-input-error for="payment.session" />
          </div>

          <div class="col-md-6 mb-2">
            <x-label>Term <span class="text-danger">*</span></x-label>
            <x-select wire:model.defer="payment.term_id">
              @if(count($terms) > 0)
                @foreach($terms as $t)
                  <option value="{{ $t->id }}">{{ $t->name }}</option>
                @endforeach
              @endif
            </x-select>
            <x-input-error for="payment.term_id" />
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
            <x-select wire:model.defer="payment.class_room_id">
              <option selected value="NULL">ALL CLASSES</option>
              @foreach($classes as $class)
                <option value="{{ $class->id }}">{{ $class->name }}</option>
              @endforeach
            </x-select>
            <x-input-error for="payment.class_room_id" />
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
          </div>
        </div>
      </x-slot>

      <x-slot name="footer">
        <x-button value="dark" wire:click="cancel">Close</x-button>
        <x-button value="submit" wire:click.prevent="store">Update</x-button>
      </x-slot>
    </x-modal>

    <x-modal id="editIndividualPaymentModal">
      <x-slot name="title">Edit Individual Payment</x-slot>

      <x-slot name="content">
        <div class="row">
          <div class="col-md-6 mb-2">
            <x-label>Session <span class="text-danger">*</span></x-label>
            <x-select wire:model="payment.session">
              @foreach(all_sessions() as $sess)
                <option value="{{ $sess }}">{{ $sess }}</option>
              @endforeach
            </x-select>
            <x-input-error for="payment.session" />
          </div>

          <div class="col-md-6 mb-2">
            <x-label>Term <span class="text-danger">*</span></x-label>
            <x-select wire:model.defer="payment.term_id">
              @if(count($terms) > 0)
                @foreach($terms as $t)
                  <option value="{{ $t->id }}">{{ $t->name }}</option>
                @endforeach
              @endif
            </x-select>
            <x-input-error for="payment.term_id" />
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
            <x-select wire:model="payment.class_room_id">
              @if(count($classes) > 0)
                @foreach($classes as $class)
                  <option value="{{ $class->id }}">{{ $class->name }}</option>
                @endforeach
              @endif
            </x-select>
            <x-input-error for="payment.class_room_id" />
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-2">
            <x-label>Student</x-label>
            <x-select wire:model.defer="payment.student_id">
              @if(count($students) > 0)
                @foreach($students as $st)
                  <option value="{{ $st->id }}">{{ $st->fullname }}</option>
                @endforeach
              @endif
            </x-select>
            <x-input-error for="payment.student_id" />
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
          </div>
        </div>
      </x-slot>

      <x-slot name="footer">
        <x-button value="dark" wire:click="cancel">Close</x-button>
        <x-button value="submit" wire:click.prevent="store">Update</x-button>
      </x-slot>
    </x-modal>

    <x-confirmation-modal id="deleteSelectedModal">
      <x-slot name="title">Delete Payment</x-slot>

      <x-slot name="content">
        Are you sure you want to delete these payments? This action is irreversible.
      </x-slot>

      <x-slot name="footer">
        <x-button value="dark" wire:click="cancel">Cancel</x-button>
        <x-button value="danger" wire:click.prevent="deleteSelected">Delete</x-button>
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
