<x-app-layout>
  Current Session : {{ \App\Helpers\SP::getSetting('current_session') }}

  <livewire:components.show-notice />
</x-app-layout>