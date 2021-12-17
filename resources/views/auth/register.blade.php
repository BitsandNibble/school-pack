<x-guest-layout>
    <div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
      <div class="container-fluid">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-2 row-cols-xl-3">
          <div class="col mx-auto">
            <div class="mb-4 text-center" style="position: inherit">
              <img src="{{ asset('assets/images/logo-img.png') }}" width="180" alt="" />
            </div>
  
            <x-card class="p-4">
              <div class="text-center">
                <h1 class="___class_+?9___">Register</h1>
                <br>
                <x-validation-errors />
              </div>
              <div class="form-body">
                <form class="row g-3" method="POST">
                  <form class="row g-3" method="POST" action="{{ route('register') }}">
                  @csrf
                  <div class="col-12">
                    <x-label for="name">Name</x-label>
                    <x-input type="text" id="name" name="name" :value="old('name')" />
                  </div>
                  <div class="col-12">
                    <x-label for="email">Email Address</x-label>
                    <x-input type="email" id="email" name="email" :value="old('email')" />
                  </div>
                  <div class="col-12">
                    <x-label for="password">Password</x-label>
                    <div class="input-group" id="show_hide_password">
                      <x-input type="password" name="password" class="border-end-0" id="password" />
                      <a href="javascript:;" class="input-group-text bg-transparent">
                        <i class='bx bx-hide'></i>
                      </a>
                    </div>
                  </div>
                  <div class="col-12">
                    <x-label for="password_confirmation">Confirm Password</x-label>
                    <div class="input-group">
                      <x-input type="password" name="password_confirmation" class="border-end-0" id="password_confirmation" />
                      <a href="javascript:;" class="input-group-text bg-transparent">
                      </a>
                    </div>
                  </div>
  
                  <div class="col-12">
                    <x-label for="user">Register as</x-label>
                    <x-select>
                      <option value="1">Principal</option>
                      <option value="2">Teacher</option>
                      <option value="3">Student</option>
                      <option value="4">Parent</option>
                    </x-select>
                  </div>
  
                  <div class="col-12">
                    <div class="d-grid">
                      <x-button type="submit">
                        Register
                      </x-button>
                    </div>
                  </div>
                </form>
              </div>
            </x-card>
          </div>
        </div>
        <!--end row-->
      </div>
    </div>
  
    @push('scripts')
      <script>
        $(document).ready(function() {
          $("#show_hide_password a").on('click', function(event) {
            event.preventDefault();
            if ($('#show_hide_password input').attr("type") == "text") {
              $('#show_hide_password input').attr('type', 'password');
              $('#show_hide_password i').addClass("bx-hide");
              $('#show_hide_password i').removeClass("bx-show");
            } else if ($('#show_hide_password input').attr("type") == "password") {
              $('#show_hide_password input').attr('type', 'text');
              $('#show_hide_password i').removeClass("bx-hide");
              $('#show_hide_password i').addClass("bx-show");
            }
          });
        });
      </script>
    @endpush
  </x-guest-layout>
  