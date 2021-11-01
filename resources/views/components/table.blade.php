@props(['size' => 'sm'])

<table {{ $attributes->merge(['class' => 'table table-striped table-'.$size]) }} style="width: 100%">
  {{ $slot }}
</table>