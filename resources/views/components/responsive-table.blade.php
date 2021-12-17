@props(['size' => 'sm'])

<div class="table-responsive">
  <x-table :size="$size">
    <x-slot name="head">{{ $head }}</x-slot>

    <x-slot name="body">{{ $body }} </x-slot>
  </x-table>
</div>