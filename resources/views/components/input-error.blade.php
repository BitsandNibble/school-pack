@props(['for', 'customMessage'])

@error($for)
<p {{ $attributes->merge(['class' => 'text-danger mt-1 mb-0']) }}>{{ $customMessage ?? $message }}</p>
@enderror
