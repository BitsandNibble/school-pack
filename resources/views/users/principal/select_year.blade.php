<x-app-layout>
  <x-breadcrumb>
    Results
    <li class="breadcrumb-item active" aria-current="page">Mark Sheet</li>
    <li class="breadcrumb-item active" aria-current="page">Select Year</li>
  </x-breadcrumb>

  <x-card>
    <div class="row d-flex justify-content-center text-center">
      <div class="col-6">
        <form action="{{ route('principal.result.marksheet.select_year') }}" method="POST">
          @csrf
          <x-label for="select_year" class="fw-bolder">Select Exam Year</x-label>
          <x-select id="select_year" class="mb-2" name="year">
            <option
                value="{{ \App\Helpers\SP::getSetting('current_session') }}">{{ \App\Helpers\SP::getSetting('current_session') }}</option>
          </x-select>

          <x-input type="hidden" value="{{ $student_id }}" name="id"></x-input>

          <x-button type="submit">Submit</x-button>
        </form>
      </div>
    </div>
  </x-card>
</x-app-layout>