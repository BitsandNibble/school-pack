<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Laravel</title>

  <!-- Styles -->
  @include('layouts.styles')

  @livewireStyles
</head>

<body>
  {{-- wrapper --}}
  <div class="wrapper">
    {{-- sidebar wrapper --}}
    <div class="sidebar-wrapper" data-simplebar="true">
      <div class="sidebar-header">
        <div>
          <img src="assets/images/logo-icon.png" class="logo-icon" alt="logo icon">
        </div>
        <div>
          <h4 class="text-dark logo-text">School Pack</h4>
        </div>
        <div class="toggle-icon ms-auto text-dark"><i class='bx bx-first-page'></i>
        </div>
      </div>
      {{-- navigation --}}
      <ul class="metismenu" id="menu">
        {{-- menu content here --}}
        @include('layouts.side-nav')
      </ul>
      {{-- end navigation --}}
    </div>
    {{-- end sidebar wrapper --}}

    {{-- header --}}
    <header class="top-header">
      {{-- header content here --}}
      @include('layouts.header')
    </header>
    {{-- end header --}}

    {{-- page wrapper --}}
    <div class="page-wrapper">
      <div class="page-content">
        <x-flash />
        {{-- page content here --}}
        {{ $slot }}
      </div>
    </div>
    {{-- end page wrapper --}}


    {{-- footer --}}
    @include('layouts.footer')
    {{-- end footer --}}
  </div>
  {{-- end wrapper --}}

  @stack('modals')

  <!-- Scripts -->
  @livewireScripts

  @include('layouts.scripts')
</body>

</html>
