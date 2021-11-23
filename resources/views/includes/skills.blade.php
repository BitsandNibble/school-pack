<div class="row">
  <div class="col-5">
    <x-table class="table-bordered" style="border: solid 1px">
      <thead>
        <th>AFFECTIVE SKILLS</th>
        <th>RATING</th>
      </thead>
      <tbody>
        @foreach($skills->where('skill_type', 'AF') as $af)
          <tr>
            <td>{{ $af->name }}</td>
            <td>{{ $exam_record->af ? explode(',', $exam_record->af)[$loop->index] : '-' }}</td>
          </tr>
        @endforeach
      </tbody>
    </x-table>
  </div>

  <div class="col-5">
    <x-table class="table-bordered" style="border: solid 1px">
      <thead>
        <th>BEHAVIOUR</th>
        <th>RATING</th>
      </thead>
      <tbody>
        @foreach($skills->where('skill_type', 'PS') as $ps)
          <tr>
            <td>{{ $ps->name }}</td>
            <td>{{ $exam_record->ps ? explode(',', $exam_record->ps)[$loop->index] : '' }}</td>
          </tr>
        @endforeach
      </tbody>
    </x-table>
  </div>

  <div class="col-2">
    <h6 class="fw-bold text-decoration-underline">KEY</h6>
    <ul class="list-unstyled">
      <li>5 - Excellent</li>
      <li>4 - Very Good</li>
      <li>3 - Good</li>
      <li>2 - Fair</li>
      <li>1 - Poor</li>
    </ul>
  </div>
</div>