<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Laravel</title>

  <!-- Styles -->
  @include('layouts.styles')
  @stack('styles')

  @livewireStyles
</head>

<body>
  <!--wrapper-->
  <div class="wrapper">
    <div class="authentication-header"></div>

    {{ $slot }}
  </div>
  <!-- Scripts -->
  @livewireScripts

  @include('layouts.scripts')
  @stack('scripts')
</body>

</html>
