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
              <h1 class="___class_+?9___">Sign in</h1>
              <br>
              <x-validation-errors />
            </div>
            <div class="form-body">
              {{--              <form class="row g-3" method="POST">--}}
              <form class="row g-3" method="POST" action="{{ route('login') }}">
                @csrf

                <div class="col-12">
                  <x-label for="login">Email / ID</x-label>
                  <x-input type="text" id="login" name="login" :value="old('login')" />
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
                  <x-label for="user_type">Login As</x-label>
                  <x-select id="user_type" name="user_type">
                    <option value="principal" {{ old('user_type') === 'principal' ? 'selected' : ''  }}>Principal
                    </option>
                    <option value="teacher" {{ old('user_type') === 'teacher' ? 'selected' : ''  }}>Teacher</option>
                    <option value="student" {{ old('user_type') === 'student' ? 'selected' : ''  }}>Student</option>
                    <option value="parent" {{ old('user_type') === 'parent' ? 'selected' : ''  }}>Parent</option>
                  </x-select>
                </div>

                <div class="col-md-6">
                  <div class="form-check form-switch">
                    <x-checked-input type="checkbox" name="agree" id="agree" />
                    <x-checked-label for="agree">Remember Me</x-checked-label>
                  </div>
                </div>

                @if (Route::has('password.request'))
                  <div class="col-md-6 text-end">
                    <a href="{{ route('password.request') }}">Forgot Password ?</a>
                  </div>
                @endif

                <div class="col-12">
                  <div class="d-grid">
                    <x-button type="submit">
                      <i class="bx bxs-lock-open"></i>
                      Sign in
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
        $(document).ready(function () {
            $("#show_hide_password a").on('click', function (event) {
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
