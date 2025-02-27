<?php

namespace App\Http\Livewire\Pages\Principal;

use Livewire\Component;
use App\Models\ClassRoom;
use App\Models\ClassType;
use Illuminate\Support\Str;
use App\Traits\WithSorting;
use Livewire\WithPagination;
use App\Traits\WithBulkActions;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Contracts\Foundation\Application;

/**
 * @property mixed rowsQuery
 * @property mixed rows
 */
class Classes extends Component
{
    use WithPagination;
    use LivewireAlert;
    use WithBulkActions;
    use WithSorting;

    public $name;
    public $deleting;
    public $class_id;
    public $class_type_id;
    public string $q = "";
    public $paginate = 10;

    protected string $paginationTheme = 'bootstrap';

    protected $queryString = [
        'q' => ['except' => ''],
    ];

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', Rule::unique('class_rooms')->ignore($this->class_id)],
            'class_type_id' => ['required'],
        ];
    }

    protected array $validationAttributes = [
        'class_type_id' => 'class type',
    ];

    public function getRowsQueryProperty()
    {
        $query = ClassRoom::query()
            ->when($this->q, fn($query) => $query->search($this->q))
            ->with('class_type');

        return $this->applySorting($query); // apply sorting
    }

    public function getRowsProperty()
    {
        return $this->rowsQuery->paginate($this->paginate);
    }

    public function render(): Factory|View|Application
    {
        if ($this->selectAll) $this->selectPageRows(); // for checkbox

        $classes = $this->rows;
        $class_types = ClassType::get();

        return view('livewire.pages.principal.classes', compact('classes', 'class_types'));
    }

    public function cancel(): void
    {
        $this->emit('closeModal');
        $this->reset();
		$this->resetErrorBag();
	}

    public function edit($id): void
    {
        $class = ClassRoom::where('id', $id)->first();
        $this->class_id = $id;
        $this->name = $class->name;
        $this->class_type_id = $class->class_type_id;
    }

    public function store(): void
    {
        $this->validate();

        if ($this->class_id) {
            $class = ClassRoom::find($this->class_id);
            $class->update([
                'name' => $this->name,
                'class_type_id' => $this->class_type_id,
                'slug' => Str::slug($this->name),
            ]);
            $this->alert('success', 'Class Updated Successfully');
        } else {
            ClassRoom::create([
                'name' => $this->name,
                'class_type_id' => $this->class_id,
                'slug' => Str::slug($this->name),
            ]);
            $this->alert('success', 'Class Added Successfully');
        }

        $this->cancel();
    }

    public function openDeleteModal($id): void
    {
        $del = ClassRoom::find($id);
        $this->deleting = $del['id'];
    }

    public function delete(ClassRoom $class): void
    {
        $class->delete();
        $this->cancel();
        $this->alert('success', 'Class Deleted Successfully');
    }
}
