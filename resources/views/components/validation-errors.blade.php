@if ($errors->any())
  <div {{ $attributes }}>
    <ul>
      @foreach ($errors->all() as $error)
        <p class="text-danger mb-0">{{ $error }}</p>
      @endforeach
    </ul>
  </div>
@endif
