<div>
  <x-breadcrumb>
    Grading
    <li class="breadcrumb-item active" aria-current="page">Skills</li>
  </x-breadcrumb>
  <x-flash />

  <x-card>
    <div class="d-flex align-items-center">
      {{-- <h4 class="my-1">Class</h4> --}}

      <div class="ms-auto d-flex justify-content-end">
        <x-button data-bs-toggle="modal" data-bs-target="#skillModal">Add New Skill</x-button>
      </div>
    </div>
  </x-card>

  <x-card>
    <x-responsive-table>
      <thead>
        <tr>
          <th>S/N</th>
          <th>Name</th>
          <th>Skill Type</th>
          <th>Class Type</th>
          <th></th>
        </tr>
      </thead>

      <tbody>
        @forelse($skills as $sk)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $sk->name }}</td>
            <td>{{ $sk->skill_type }}</td>
            <td>{{ $sk->class_type->name }}</td>
            <td>
              <x-button class="px-0" wire:click="edit({{ $sk->id }})" value="" data-bs-toggle="modal"
                        data-bs-target="#skillModal">
                <i class="bx bxs-pen"></i>
              </x-button>
              <x-button class="px-0" value="" wire:click="openDeleteModal({{ $sk->id }})"
                        data-bs-toggle="modal" data-bs-target="#deleteModal">
                <i class="bx bxs-trash-alt"></i>
              </x-button>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6" class="text-center">No record found</td>
          </tr>
        @endforelse
      </tbody>
    </x-responsive-table>
  </x-card>


  <x-modal id="skillModal">
    <x-slot name="title">{{ isset($this->skill_id) ? 'Edit' : 'Add New' }} Skill</x-slot>

    <x-slot name="content">
      <p><span class="text-danger">*</span> fields are required</p>
      <p>If the skill you are creating applies to all class types select NOT APPLICABLE. Otherwise select the Class
        Type That the grade applies to</p>

      <div class="row">
        {{--         <x-validation-errors />--}}

        <div class="col-md-4 mb-2">
          <x-label for="skill">Name <span class="text-danger">*</span></x-label>
          <x-input type="text" id="skill" wire:model.defer="skill.name" />
          <x-input-error for="skill.name" />
        </div>

        <div class="col-md-4 mb-2">
          <x-label for="skill_type">Skill Type <span class="text-danger">*</span></x-label>
          <x-select id="skill_type" wire:model.defer="skill.skill_type">
            <option value="AF">Affective Traits/Skills</option>
            <option value="PS">Psychomotor Traits/Skills</option>
          </x-select>
          <x-input-error for="skill.skill_type" />
        </div>

        <div class="col-md-4 mb-2">
          <x-label for="class_type">Class Type</x-label>
          <x-select id="class_type" wire:model.defer="skill.class_type_id">
            <option value="NULL">Not Applicable</option>
            @foreach ($class_types as $ct)
              <option value="{{ $ct->id }}">{{ $ct->name }}</option>
            @endforeach
          </x-select>
        </div>
      </div>
    </x-slot>

    <x-slot name="footer">
      <x-button value="dark" wire:click="cancel">Close</x-button>
      <x-button value="submit" wire:click.prevent="store">Save</x-button>
    </x-slot>
  </x-modal>

  <x-confirmation-modal id="deleteModal">
    <x-slot name="title">Delete Grade</x-slot>

    <x-slot name="content">
      Are you sure you want to delete this grade?
    </x-slot>

    <x-slot name="footer">
      <x-button value="dark" wire:click="cancel">Cancel</x-button>
      <x-button value="danger" wire:click.prevent="delete({{ $deleting }})">Delete</x-button>
    </x-slot>
  </x-confirmation-modal>

  <x-spinner />
</div>