    <x-base-layout>
      <x-breadcrumb>Components</x-breadcrumb>

      <section>
        <x-card>
          <h1 class="card-title">Buttons</h1>

          <x-button.primary>Primary</x-button.primary>
          <x-button.danger>Danger</x-button.danger>
          <x-button.success>Success</x-button.success>
          <x-button.submit>Submit</x-button.submit>
          <x-button.cancel>Cancel</x-button.cancel>

          <br><br>

          <x-button.primary-outline>Primary</x-button.primary-outline>
          <x-button.danger-outline>Danger</x-button.danger-outline>
          <x-button.success-outline>Success</x-button.success-outline>
          <x-button.submit-outline>Submit</x-button.submit-outline>
          <x-button.cancel-outline>Cancel</x-button.cancel-outline>

          <br><br>

          <x-button.primary-rounded>Primary</x-button.primary-rounded>
          <x-button.danger-rounded>Danger</x-button.danger-rounded>
          <x-button.success-rounded>Success</x-button.success-rounded>
          <x-button.submit-rounded>Submit</x-button.submit-rounded>
          <x-button.cancel-rounded>Cancel</x-button.cancel-rounded>

          <br><br>

          <x-button.primary-rounded-outline>Primary</x-button.primary-rounded-outline>
          <x-button.danger-rounded-outline>Danger</x-button.danger-rounded-outline>
          <x-button.success-rounded-outline>Success</x-button.success-rounded-outline>
          <x-button.submit-rounded-outline>Submit</x-button.submit-rounded-outline>
          <x-button.cancel-rounded-outline>Cancel</x-button.cancel-rounded-outline>
        </x-card>
      </section>

      <section class="mt-3">
        <x-card>
          <div class="border p-2 rounded">
            <h1 class="card-title">Form Components</h1>

            <div class="row">
              <div class="col-md-4">
                <x-form.label for="first_name">First name</x-form.label>
                <x-form.input type="text" id="first_name" />
                {{-- <x-form.input class="is-invalid mt-2" id="first_name" /> --}}
                <x-form.input-error for="first_name">Please enter your firstname</x-form.input-error>
              </div>

              <div class="col-md-4">
                <x-form.label for="lastname">Last name</x-form.label>
                <x-form.input type="text" id="lastname" />
                <x-form.input-error for="lastname">Please enter your lastname</x-form.input-error>
              </div>

              <div class="col-md-4">
                <x-form.label for="username">Username</x-form.label>
                <div class="input-group"> <span class="input-group-text">@</span>
                  <x-form.input type="text" id="username" />
                </div>
                <x-form.input-error for="username">Please choose a username</x-form.input-error>
              </div>
            </div>

            <div class="row mt-2">
              <div class="col-md-6">
                <x-form.label for="address">Address</x-form.label>
                <x-form.textarea id="address" placeholder=""></x-form.textarea>
                <x-form.input-error for="address">Please enter your address</x-form.input-error>
              </div>

              <div class="col-md-3">
                <x-form.label for="state">State</x-form.label>
                <x-form.select>
                  <option>...</option>
                  <option>...</option>
                  <option>...</option>
                </x-form.select>
                <x-form.input-error for="state">Please choose a state</x-form.input-error>
              </div>

              <div class="col-md-3">
                <x-form.label for="dob">Date of birth</x-form.label>
                <x-form.date id="dob" />
                <x-form.input-error for="dob">Please pick you dob</x-form.input-error>
              </div>
            </div>

            <div class="row mt-2">
              <div class="col-md-6">
                <x-form.label>Gender</x-form.label> <br>
                <x-form.checked-input type="radio" name="gender" id="gender" />
                <x-form.checked-label for="gender">Male</x-form.checked-label>

                <x-form.checked-input type="radio" name="gender" id="gender" />
                <x-form.checked-label for="gender">Female</x-form.checked-label>

                <x-form.checked-input type="radio" name="gender" id="gender" />
                <x-form.checked-label for="gender">Other</x-form.checked-label>
                <x-form.input-error for="gender">Please choose a gender</x-form.input-error>
              </div>

              <div class="col-md-6">
                <x-form.label for="image">Image</x-form.label>
                <x-form.input type="file" id="image" />
                <x-form.input-error for="image">Please upload an image</x-form.input-error>
              </div>
            </div>

            <x-form.checked-label for="agree">
              <x-form.checked-input type="checkbox" name="agree" id="agree" />Agree to terms and conditions
            </x-form.checked-label>
          </div>
        </x-card>
      </section>

      <section>
        <x-card>
          <h1 class="card-title">Modals</h1>

          <x-button.primary data-bs-toggle="modal" data-bs-target="#lgmodal">Open Modal</x-button.primary>

          <x-button.danger-rounded-outline data-bs-toggle="modal" data-bs-target="#anotherModal">Open Modal
          </x-button.danger-rounded-outline>

        </x-card>
      </section>




      @push('modals')
        <x-modal id="lgmodal">
          <x-slot name="title">A Large Modal</x-slot>

          Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin
          literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney
          College in Virginia, looked up one of the more obscure Latin words, consectetur.

          <x-slot name="footer">
            <x-button.submit>Save</x-button.submit>
          </x-slot>
        </x-modal>

        <x-modal id="anotherModal">
          <x-slot name="title">Another Modal</x-slot>

          Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin
          literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney
          College in Virginia, looked up one of the more obscure Latin words, consectetur.

          <x-slot name="footer">
            <x-button.submit>Save</x-button.submit>
          </x-slot>
        </x-modal>
      @endpush
    </x-base-layout>
