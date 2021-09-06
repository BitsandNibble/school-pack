<?php

namespace App\Http\Livewire\Pages\Principal;

use App\Models\School;
use Livewire\Component;

class Settings extends Component
{

  public $school;

  protected $rules = [
    'school.name' => 'required|string',
    'school.address' => 'required|string',
    'school.phone_number1' => 'required|numeric',
    'school.phone_number2' => 'numeric',
    'school.school_logo' => 'sometimes|image|max:2048',
  ];

  protected $validationAttributes = [
    'school.name' => 'name',
    'school.address' => 'address',
    'school.phone_number1' => 'phone number',
    'school.phone_number2' => 'phone number',
    'school.school_logo' => 'logo',
  ];

  public function render()
  {
    // $class = ClassRoom::where('id', $id)->with('teachers')->first();
    // $this->class_id = $class['id'];
    // $this->name = $class->name;

    $school = School::first();
    // // dd($school);
    $this->school = $school;

    return view('livewire.pages.principal.settings');
  }

  public function store()
  {
    $this->validate();

    School::updateOrCreate(
      [$this->school['name']],
      [
      'name' => $this->school['name'],
      'address' => $this->school['address'],
      'phone_number1' => $this->school['phone_number1'],
      'phone_number2' => $this->school['phone_number2'] ?? '',
      'school_logo' => $this->school['school_logo'] ?? '',
    ]);
    session()->flash('message', 'School Details Updated Successfully');
  }
}
