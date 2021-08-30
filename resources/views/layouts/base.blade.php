<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Laravel</title>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- Styles -->
  {{-- <link rel="stylesheet" href="{{ mix('css/app.css') }}"> --}}
  <link rel="stylesheet" href="{{ mix('css/main.css') }}">
  <link rel="stylesheet" href="{{ mix('css/custom.css') }}">
  <link rel="stylesheet" href="{{ mix('css/plugins.css') }}">

  @livewireStyles
</head>

<body>
  {{-- wrapper --}}
  <div class="wrapper">
    {{-- sidebar wrapper --}}
    <div class="sidebar-wrapper" data-simplebar="true">
      {{-- navigation --}}
      <ul class="metismenu" id="menu">
        {{-- menu content here --}}
      </ul>
      {{-- end navigation --}}
    </div>
    {{-- end sidebar wrapper --}}

    {{-- header --}}
    <header class="top-header">
      {{-- header content here --}}
    </header>
    {{-- end header --}}

    {{-- page wrapper --}}
    <div class="page-wrapper">
      {{-- page content wrapper --}}
      <div class="page-content-wrapper">
        <div class="page-content">
          <x-flash />
          {{-- page content here --}}
          {{ $slot }}
        </div>
      </div>
      {{-- end page-content wrapper --}}
    </div>
    {{-- end page wrapper --}}


    {{-- footer --}}
    <div class="footer">
      {{-- footer content here --}}
    </div>
    {{-- end footer --}}
  </div>
  {{-- end wrapper --}}

  @stack('modals')

  <!-- Scripts -->
  @livewireScripts

  <script src="{{ mix('js/main.js') }}" defer></script>
  <script src="{{ mix('js/main.min.js') }}" defer></script>
  <script src="{{ mix('js/plugins.js') }}" defer></script>
</body>

</html>
