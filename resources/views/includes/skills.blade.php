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
            {{--            fix inserting values as array/json into the db--}}
            {{--            <td>@json($af_skills[$loop->index ?? 0])</td>--}}
            <td>{{ $loop->index }}</td>
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
            {{--            fix inserting values as array/json into the db--}}
            {{--            <td>@json($ps_skills[$loop->index ?? 0])</td>--}}
            <td>{{ $loop->index }}</td>
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