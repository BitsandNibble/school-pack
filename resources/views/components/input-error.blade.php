@props(['for'])

@error($for)
  <p {{ $attributes->merge(['class' => 'invalid-feedback']) }}>{{ $message }}</p>
@enderror
