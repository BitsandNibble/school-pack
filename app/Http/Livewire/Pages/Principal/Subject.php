<?php

namespace App\Http\Livewire\Pages\Principal;

use App\Models\Teacher;
use Livewire\Component;
use App\Models\ClassRoom;
use Illuminate\Contracts\View\View;
use App\Models\ClassSubjectTeacher;
use App\Models\Subject as SubjectModel;
use Illuminate\Contracts\View\Factory;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Contracts\Foundation\Application;

/**
 * @method static where(string $string, $id)
 */
class Subject extends Component
{
    use LivewireAlert;

    public $q;
    public $class_id;
    public $deleting;
    public $class_subject_teacher;
    public $subject;
    public $teacher;

    public array $rules = [
        'subject' => 'required',
        'teacher' => 'required'
    ];

    public function cancel(): void
    {
        $this->emit('closeModal');
        $this->reset(['teacher', 'subject']);
		$this->resetErrorBag();
	}

    public function mount($id): void
    {
        $this->class_id = $id;
    }

    public function render(): Factory|View|Application
    {
        $allTeachers = Teacher::get();
        $class = ClassRoom::find($this->class_id);
        $availableSubjects = SubjectModel::get();
        $classes = ClassSubjectTeacher::where('class_room_id', $this->class_id)
            ->with('subject', 'teacher')
            ->get();

        return view('livewire.pages.principal.subject', compact('availableSubjects', 'classes', 'allTeachers', 'class'));
    }

    public function edit($id): void
    {
        $class = ClassSubjectTeacher::find($id);
        $this->class_subject_teacher = $id;

        $this->subject = $class->subject->id;
        $this->teacher = $class->teacher->id;
    }

    public function store(): void
    {
        $this->validate();

        if ($this->class_subject_teacher) {
            $class = ClassSubjectTeacher::find($this->class_subject_teacher);
            $class->update([
                'class_room_id' => $this->class_id,
                'subject_id' => $this->subject,
                'teacher_id' => $this->teacher,
            ]);
        } else {
            ClassSubjectTeacher::create([
                'class_room_id' => $this->class_id,
                'subject_id' => $this->subject,
                'teacher_id' => $this->teacher,
            ]);
        }

        $this->alert('success', 'Added Successfully');
        $this->cancel();
    }

    public function openDeleteModal($id): void
    {
        $del = ClassSubjectTeacher::find($id);
        $this->deleting = $del['id'];
    }

    public function delete(ClassSubjectTeacher $cst): void
    {
        $cst->delete();
        $this->alert('success', 'Subject Deleted Successfully');
        $this->cancel();
    }
}
