<x-card-with-header>
  <x-slot name="header">
    <h6 class="fw-bold my-auto">Notice Board</h6>
  </x-slot>

  @foreach($notices as $notice)
    <h6 class="fw-bolder">{{ $notice->title }}</h6>
    <p class="text-truncate">{{ $notice->message }}</p>
    <h6>Author: {{ $notice->principal->fullname }}</h6>
    <div class="float-end mb-2">
      <h6>Posted: {{ $notice->created_at }}</h6>
      <h6>Updated: {{ $notice->updated_at }}</h6>
    </div>
    <br>
    <br>
    <br>
    <br>
  @endforeach
</x-card-with-header>