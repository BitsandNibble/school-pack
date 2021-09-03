<select {{ $attributes->merge(['class' => 'form-select']) }}>
  <option selected disabled value="">Select One...</option>
  {{ $slot }}
</select>
