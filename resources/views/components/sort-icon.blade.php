@props(['sortBy', 'sortAsc', 'sortField'])

@if ($sortBy == $sortField)
  @if ($sortAsc)
    <i class="bx bx-sort-up"></i>
  @else
    <i class="bx bx-sort-down"></i>
  @endif
@endif
