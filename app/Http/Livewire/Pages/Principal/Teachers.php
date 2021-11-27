<?php

namespace App\Http\Livewire\Pages\Principal;

use Exception;
use App\Models\Section;
use App\Models\Teacher;
use Livewire\Component;
use App\Models\ClassRoom;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use App\Traits\WithBulkActions;
use Illuminate\Validation\Rule;
use App\Models\ClassSubjectTeacher;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\View\Factory;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Contracts\Foundation\Application;

/**
 * @property mixed rowsQuery
 * @property mixed rows
 */
class Teachers extends Component
{
  use WithPagination;
  use LivewireAlert;
  use WithBulkActions;

  public string $q = "";
  public string $sortBy = 'fullname';
  public bool $sortAsc = true;
  public int $paginate = 10;
  public $teacher;
  public $teacher_info;
  public $teacher_class_info;
  public $deleting;
  public $teacher_id;
  public $assigned_subject_id;
  public $section;

  protected string $paginationTheme = 'bootstrap';

  protected $queryString = [
    'q' => ['except' => ''],
    'sortBy' => ['except' => 'fullname'],
    'sortAsc' => ['except' => true],
  ];

  protected function rules(): array
  {
    return [
      'teacher.title' => 'required',
      'teacher.fullname' => ['required', 'string', Rule::unique('teachers', 'fullname')->ignore($this->teacher_id)],
      'teacher.email' => ['sometimes', 'email', Rule::unique('teachers', 'email')->ignore($this->teacher_id)],
      'teacher.gender' => 'sometimes',
      'teacher.date_of_employment' => 'sometimes',
    ];
  }

  protected array $validationAttributes = [
    'teacher.title' => 'title',
    'teacher.fullname' => 'fullname',
    'teacher.email' => 'email',
    'teacher.gender' => 'gender',
    'teacher.date_of_employment' => 'date of employment',
  ];

  public function getRowsQueryProperty()
  {
    return Teacher::query()
      ->when($this->q, function ($query) {
        return $query->search($this->q);
      });
  }

  public function getRowsProperty()
  {
    return $this->rowsQuery->paginate($this->paginate);
  }

  public function render(): Factory|View|Application
  {
    if ($this->selectAll) $this->selectPageRows(); // for checkbox

    $teachers = $this->rows;

    return view('livewire.pages.principal.teachers', compact('teachers'));
  }

  public function updatingQ(): void
  {
    $this->resetPage();
  }

  public function sortBy($field): void
  {
    if ($field === $this->sortBy) {
      $this->sortAsc = !$this->sortAsc;
    }
    $this->sortBy = $field;
  }

  public function cancel(): void
  {
    $this->emit('closeModal');
    $this->reset();
  }

  public function edit($id): void
  {
    $teacher = Teacher::where('id', $id)->first();
    $this->teacher_id = $teacher['id'];
    $this->teacher = $teacher;
  }

  /**
   * @throws Exception
   */
  public function store(): void
  {
    $this->validate();

    if ($this->teacher_id) {
      $teacher = Teacher::find($this->teacher_id);
      $teacher->update([
        'fullname' => $this->teacher['fullname'],
        'title' => $this->teacher['title'],
        'email' => $this->teacher['email'] ?? '',
        'gender' => $this->teacher['gender'] ?? '',
        'date_of_employment' => $this->teacher['date_of_employment'] ?? '',
        'slug' => Str::slug($this->teacher['fullname']),
      ]);
      $this->alert('success', 'Teacher Updated Successfully');
    } else {
      Teacher::create([
        'fullname' => $this->teacher['fullname'],
        'title' => $this->teacher['title'],
        'email' => $this->teacher['email'] ?? '',
        'gender' => $this->teacher['gender'] ?? '',
        'date_of_employment' => $this->teacher['date_of_employment'] ?? '',
        'school_id' => 'GS_' . random_int(500, 1000),
        'password' => Hash::make('password'),
        'slug' => Str::slug($this->teacher['fullname']),
      ]);
      $this->alert('success', 'Teacher Added Successfully');
    }

    $this->cancel();
  }

  public function showInfo($id): void
  {
    $this->teacher_info = Teacher::where('id', $id)
      ->with('nationality', 'state', 'lga')
      ->get();

    $sec = Section::with('class_room')->where('teacher_id', $id)->first();

    $this->assigned_subject_id = ClassSubjectTeacher::where('teacher_id', $id)
      ->with('class_room', 'subject')
      ->get();
    $this->teacher_class_info = is_null($sec) ? '' : $sec->class_room->name;

    $this->section = is_null($sec) ? '' : ' - ' . $sec->name;
  }

  public function deleteExistingClass($id): void
  {
    $class = ClassRoom::where('id', $id)->with('teachers')->first();

    foreach ($class->teachers()->get() as $classTeacher) {
      $class->teachers()->detach($classTeacher->id);
    }

    $this->cancel();
  }

  public function openDeleteModal($id): void
  {
    $del = Teacher::find($id);
    $this->deleting = $del['id'];
  }

  public function delete(Teacher $teacher): void
  {
    $teacher->delete();
    $this->cancel();
    $this->alert('success', 'Teacher Deleted Successfully');
  }
}
