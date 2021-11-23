<x-app-layout>
  <p>Current Session : {{ get_setting('current_session') }}</p>
  <hr>

  <livewire:components.show-notice />
</x-app-layout>