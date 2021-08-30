@props(['placeholder' => 'Enter Text Here'])

<textarea {{ $attributes->merge(['class' => 'form-control']) }} placeholder="{{ $placeholder ?? $slot }}"></textarea>
