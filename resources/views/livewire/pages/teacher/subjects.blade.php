<div>
  <x-breadcrumb>Subjects</x-breadcrumb>

  <x-card>
    {{--    <h5 class="card-title"></h5>--}}
    {{--    <hr>--}}
    <div class="accordion accordion-flush" id="studentAccordion">
      @foreach($sub as $s)
        <div class="accordion-item">
          <h2 class="accordion-header" id="flush-heading{{ $s->id }}">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#flush-collapse{{ $s->id }}" aria-expanded="false"
                    aria-controls="flush-collapse{{ $s->id }}">
              {{ $s->subject->name . ' - ' . $s->class_room->name}}
            </button>
          </h2>
          <div id="flush-collapse{{ $s->id }}" class="accordion-collapse collapse"
               aria-labelledby="flush-heading{{ $s->id }}" data-bs-parent="#studentAccordion">
            <div class="accordion-body">
              <div class="table-responsive">
                <table class="table table-striped table-bordered" style="width:100%">
                  <thead>
                    <tr>
                      <th>S/N</th>
                      <th>Full Name</th>
                    </tr>
                  </thead>

                  <tbody>
                    @forelse(\App\Models\ClassStudentSubject::where(['class_room_id' => $s->class_room_id, 'subject_id' => $s->subject_id])->get(['student_id']) as $cst)
                      <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $cst->student->fullname }}</td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="2" align="center">No record found</td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      @endforeach

      {{--      <div class="accordion-item">--}}
      {{--        <h2 class="accordion-header" id="flush-headingTwo">--}}
      {{--          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">--}}
      {{--            Accordion Item #2--}}
      {{--          </button>--}}
      {{--        </h2>--}}
      {{--        <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">--}}
      {{--          <div class="accordion-body">Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.</div>--}}
      {{--        </div>--}}
      {{--      </div>--}}
      {{--      <div class="accordion-item">--}}
      {{--        <h2 class="accordion-header" id="flush-headingThree">--}}
      {{--          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">--}}
      {{--            Accordion Item #3--}}
      {{--          </button>--}}
      {{--        </h2>--}}
      {{--        <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">--}}
      {{--          <div class="accordion-body">Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.</div>--}}
      {{--        </div>--}}
      {{--      </div>--}}
    </div>
  </x-card>
</div>