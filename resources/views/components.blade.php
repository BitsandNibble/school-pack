    <x-base-layout>
      <x-breadcrumb>Components</x-breadcrumb>

      <section>
        <x-card>
          <h1 class="card-title">Buttons</h1>

          <h6>Flat Buttons</h6>
          <x-button>Primary</x-button>
          <x-button value="secondary">Secondary</x-button>
          <x-button value="danger">Danger</x-button>
          <x-button value="success">Success</x-button>
          <x-button value="submit">Submit</x-button>
          <x-button value="info">Info</x-button>
          <x-button value="warning">Warning</x-button>
          <x-button value="dark">Dark</x-button>
          <br><br>

          <h6>Flat Outline Buttons</h6>
          <x-outline-button>Primary</x-outline-button>
          <x-outline-button value="secondary">Secondary</x-outline-button>
          <x-outline-button value="danger">Danger</x-outline-button>
          <x-outline-button value="success">Success</x-outline-button>
          <x-outline-button value="submit">Submit</x-outline-button>
          <x-outline-button value="info">Info</x-outline-button>
          <x-outline-button value="warning">Warning</x-outline-button>
          <x-outline-button value="dark">Dark</x-outline-button>
          <br><br>

          <h6>Round Buttons</h6>
          <x-round-button>Primary</x-round-button>
          <x-round-button value="secondary">Secondary</x-round-button>
          <x-round-button value="danger">Danger</x-round-button>
          <x-round-button value="success">Success</x-round-button>
          <x-round-button value="submit">Submit</x-round-button>
          <x-round-button value="info">Info</x-round-button>
          <x-round-button value="warning">Warning</x-round-button>
          <x-round-button value="dark">Dark</x-round-button>
          <br><br>

          <h6>Round Outline Buttons</h6>
          <x-round-outline-button>Primary</x-round-outline-button>
          <x-round-outline-button value="secondary">Secondary</x-round-outline-button>
          <x-round-outline-button value="danger">Danger</x-round-outline-button>
          <x-round-outline-button value="success">Success</x-round-outline-button>
          <x-round-outline-button value="submit">Submit</x-round-outline-button>
          <x-round-outline-button value="info">Info</x-round-outline-button>
          <x-round-outline-button value="warning">Warning</x-round-outline-button>
          <x-round-outline-button value="dark">Dark</x-round-outline-button>
        </x-card>
      </section>

      <section class="mt-3">
        <x-card>
          <div class="border p-2 rounded">
            <h1 class="card-title">Form Components</h1>

            <div class="row">
              <x-validation-errors />
              <div class="col-md-4">
                <x-label for="first_name">First name</x-label>
                <x-input type="text" id="first_name" />
                {{-- <x-input class="is-invalid mt-2" id="first_name" /> --}}
                <x-input-error for="first_name" custom-message="Please enter your firstname"/>
              </div>

              <div class="col-md-4">
                <x-label for="lastname">Last name</x-label>
                <x-input type="text" id="lastname" />
                <x-input-error for="lastname"/>
              </div>

              <div class="col-md-4">
                <x-label for="username">Username</x-label>
                <div class="input-group"> <span class="input-group-text">@</span>
                  <x-input type="text" id="username" />
                </div>
              </div>
            </div>

            <div class="row mt-2">
              <div class="col-md-6">
                <x-label for="address">Address</x-label>
                <x-textarea id="address" placeholder=""></x-textarea>
              </div>

              <div class="col-md-3">
                <x-label for="state">State</x-label>
                <x-select>
                  <option>...</option>
                  <option>...</option>
                  <option>...</option>
                </x-select>
              </div>

              <div class="col-md-3">
                <x-label for="dob">Date of birth</x-label>
                <x-input type="date" id="dob" />
              </div>
            </div>

            <div class="row mt-2">
              <div class="col-md-6">
                <x-label>Gender</x-label> <br>
                <x-checked-input type="radio" name="gender" id="gender" />
                <x-checked-label for="gender">Male</x-checked-label>

                <x-checked-input type="radio" name="gender" id="gender" />
                <x-checked-label for="gender">Female</x-checked-label>

                <x-checked-input type="radio" name="gender" id="gender" />
                <x-checked-label for="gender">Other</x-checked-label>
              </div>

              <div class="col-md-6">
                <x-label for="image">Image</x-label>
                <x-input type="file" id="image" />
              </div>
            </div>

            <x-checked-label for="agree">
              <x-checked-input type="checkbox" name="agree" id="agree" />Agree to terms and conditions
            </x-checked-label>
          </div>
        </x-card>
      </section>

      <section>
        <x-card>
          <h1 class="card-title">Modals</h1>

          <x-button data-bs-toggle="modal" data-bs-target="#lgmodal">Open Modal</x-button>

          <x-round-outline-button value="danger" data-bs-toggle="modal" data-bs-target="#anotherModal">Confirmation
            Modal
          </x-round-outline-button>
        </x-card>
      </section>




      @push('modals')
        <x-modal id="lgmodal">
          <x-slot name="title">A Large Modal</x-slot>

          Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin
          literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney
          College in Virginia, looked up one of the more obscure Latin words, consectetur.

          <x-slot name="footer">
            <x-button value="submit">Save</x-button>
          </x-slot>
        </x-modal>

        <x-confirmation-modal id="anotherModal">
          <x-slot name="title">Delete</x-slot>

          <div class="d-flex align-items-center">
            <div class="font-35 text-warning mb-3">
              <i class="lni lni-warning"></i>
            </div>
            <div class="ms-auto font-20">
              <p class="mb-0 text-secondary">
                Are you sure you want to delete this item ?
              </p>
            </div>
          </div>

          <x-slot name="footer">
            <x-button value="danger">Delete</x-button>
          </x-slot>
        </x-confirmation-modal>
      @endpush
    </x-base-layout>
