<x-app-layout>
  <x-breadcrumb>
    Results
    <li class="breadcrumb-item active" aria-current="page">Mark Sheet</li>
    <li class="breadcrumb-item active" aria-current="page">Select Year</li>
  </x-breadcrumb>

  <x-card>
    <div class="row d-flex justify-content-center text-center">
      <div class="col-6">

        <form action="{{ route('result.marksheet.show', [$student_id]) }}" method="POST">
          @csrf
          <x-label for="select_year" class="fw-bolder">Select Exam Year</x-label>
          <x-select id="select_year" class="mb-2" name="year">
            @foreach($years as $year)
              <option value="{{ $year->year }}" selected>{{ $year->year }}</option>
            @endforeach
          </x-select>
          <x-validation-errors />

          <x-button type="submit">Submit</x-button>
        </form>
      </div>
    </div>
  </x-card>
</x-app-layout>