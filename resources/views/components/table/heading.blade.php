@props([
    'sortable' => null,
    'direction' => null,
])

<th {{ $attributes->merge(['class' => '']) }}>
    @unless($sortable)
        <span>{{ $slot }}</span>
    @else
        <div class="d-flex justify-content-between cursor-pointer">
            <span>{{ $slot }}</span>

            @if ($direction === 'asc')
                <i class="bx bx-sort-up"></i>
            @elseif ($direction === 'desc')
                <i class="bx bx-sort-down"></i>
            @endif
        </div>
    @endunless
</th>
