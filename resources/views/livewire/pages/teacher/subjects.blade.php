<div>
  <x-breadcrumb>Subjects</x-breadcrumb>

  <x-card>
    <div class="accordion accordion-flush" id="studentAccordion">
      @foreach($sub as $s)
        <x-card :radius="10" class="bg-gradient-burning">
          <div class="d-flex align-items-center">
            <div>
              <p class="mb-0 text-dark">{{ $s->class_room->name }}</p>
              <h4 class="text-dark my-1">{{ $s->subject->name }}</h4>
            </div>
            <div class="text-dark ms-auto font-35"><i class="bx bx-user-pin"></i>
            </div>
          </div>
        </x-card>
      @endforeach
    </div>
  </x-card>
</div>