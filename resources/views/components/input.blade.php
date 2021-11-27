@props(['size' => ''])

<input {{ $attributes->merge(['class' => 'form-control form-control-'.$size]) }}>
