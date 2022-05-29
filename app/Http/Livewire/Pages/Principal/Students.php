<?php

namespace App\Http\Livewire\Pages\Principal;

use Exception;
use App\Models\Section;
use App\Models\Student;
use Livewire\Component;
use App\Models\ClassRoom;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Models\ClassStudentSubject;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\View\Factory;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Contracts\Foundation\Application;

class Students extends Component
{
    use LivewireAlert;

    public $student;
    public $student_info;
    public $offered_subjects;
    public $deleting;
    public $student_id;
    public $class;
    public $section;
    public $sections = [];

    protected $listeners = ['edit', 'showInfo', 'openDeleteModal'];

    protected function rules(): array
    {
        return [
            'student.fullname' => ['required', 'string', Rule::unique('students', 'fullname')->ignore($this->student_id)],
            'class' => 'required',
            'section' => 'required',
            'student.gender' => 'sometimes',
        ];
    }

    protected array $validationAttributes = [
        'student.fullname' => 'fullname',
        'student.gender' => 'gender',
    ];

    public function render(): Factory|View|Application
    {
        if (!empty($this->class)) {
            $this->sections = Section::where('class_room_id', $this->class)->get();
        }
        $classes = ClassRoom::orderBy('name', 'ASC')->get();

        return view('livewire.pages.principal.students', compact('classes'));
    }

    public function cancel(): void
    {
        $this->emit('closeModal');
        $this->reset();
    }

    public function edit($id): void
    {
        $student = Student::find($id);
        $this->student_id = $student['id'];
        $this->student = $student;
        $this->class = $student->class_room->id ?? '';
        $this->section = $student->section->id ?? '';
    }

    /**
     * @throws Exception
     */
    public function store(): void
    {
        $this->validate();

        if ($this->student_id) {
            $student = Student::find($this->student_id);
            $student->update([
                'fullname' => $this->student['fullname'],
                'class_room_id' => $this->class ?? '',
                'section_id' => $this->section ?? '',
                'gender' => $this->student['gender'] ?? '',
                'slug' => Str::slug($this->student['fullname']),
            ]);
            $this->alert('success', 'Student Updated Successfully');
        } else {
            Student::create([
                'fullname' => $this->student['fullname'],
                'class_room_id' => $this->class,
                'section_id' => $this->section,
                'gender' => $this->student['gender'] ?? '',
                'school_id' => 'GS_' . random_int(500, 1000),
                'password' => Hash::make('password'),
                'slug' => Str::slug($this->student['fullname']),
            ]);
            $this->alert('success', 'Student Added Successfully');
        }

        $this->emit('refresh');
        $this->cancel();
    }

    public function showInfo($id): void
    {
        $student = Student::where('id', $id)
            ->with('class_room', 'section', 'nationality', 'state', 'lga')
            ->get();

        $this->student_info = $student;
        $this->offered_subjects = ClassStudentSubject::where('student_id', $id)->get();
    }

    public function openDeleteModal($id): void
    {
        $del = Student::find($id);
        $this->deleting = $del['id'];
    }

    public function delete(Student $student): void
    {
        $student->delete();
        $this->emit('refresh');
        $this->cancel();
        $this->alert('success', 'Student Deleted Successfully');
    }
}
