<div>
  <x-breadcrumb>
    Students
    <li class="breadcrumb-item active" aria-current="page">Manage Promotions</li>
  </x-breadcrumb>
  <x-flash />

  <x-card-with-header>
    <x-slot name="header">
      <h5 class="fw-bold my-auto">Students Who Were Promoted From <span class="text-danger">{{ $old_year }}</span> TO
        <span class="text-success">{{ $new_year }}</span> Session</h5>
    </x-slot>

    <div class="table-responsive">
      <table class="table table-sm">
        <thead>
          <tr>
            <th>S/N</th>
            <th>Name</th>
            <th>From Class</th>
            <th>To Class</th>
            <th>Status</th>
            <th></th>
          </tr>
        </thead>

        <tbody>
          @forelse($promotions as $promotion)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $promotion->student->fullname }}</td>
              <td>{{ $promotion->fc->name . ' ' . $promotion->fs->name }}</td>
              <td>{{ $promotion->tc->name . ' ' . $promotion->ts->name }}</td>
              <td>{{ $promotion->status }}</td>
              <td></td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center">No record found</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

  </x-card-with-header>
</div>