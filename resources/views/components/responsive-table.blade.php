@props(['size' => 'sm'])

<div class="table-responsive">
  <table {{ $attributes->merge(['class' => 'table table-striped table-'.$size]) }} style="width: 100%">
    {{ $slot }}
  </table>
</div>