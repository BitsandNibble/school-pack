<select {{ $attributes->merge(['class' => 'form-select']) }}>
    <option selected value="">Select One...</option>
    {{ $slot }}
</select>
