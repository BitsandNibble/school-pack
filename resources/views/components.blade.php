<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Laravel</title>
  <link rel="stylesheet" href="{{ mix('css/main.css') }}">
  <link rel="stylesheet" href="{{ mix('css/custom.css') }}">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
</head>

<body class="antialiased">
  <main class="container mt-2">

    <section>
      <h1>Buttons</h1>

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
    </section>
  </main>
</body>

</html>
