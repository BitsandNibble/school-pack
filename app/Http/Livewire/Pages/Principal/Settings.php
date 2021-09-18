<?php

namespace App\Http\Livewire\Pages\Principal;

use App\Helpers\Helper;
use App\Models\School;
use App\Models\Setting;
use Livewire\Component;
use Livewire\WithFileUploads;

class Settings extends Component
{
  use WithFileUploads;

  public $settings;

  protected $rules = [
    'settings.school_name' => 'required|string',
    'settings.address' => 'required|string',
    'settings.phone' => 'required|numeric',
//    'phone_number2' => 'numeric',
//    'school_logo' => 'sometimes|image|max:2048',
  ];

  protected $validationAttributes = [
    'settings.school_name' => 'school name',
    'settings.address' => 'address',
    'settings.phone' => 'phone number',
    'settings.mobile' => 'phone number',
    'settings.school_logo' => 'logo',
  ];

  public function render()
  {
    $sets = Setting::get();
    $s['set'] = $sets->flatMap(function ($sets) {
      return [$sets->type => $sets->description];
    });
    $this->settings = $s['set'];

    return view('livewire.pages.principal.settings', $s);
  }

  public function store()
  {
    $credentials = $this->validate();
    foreach ($credentials as $cred) {}

    $keys = array_keys($cred);
    $values = array_values($cred);
    $iMax = Helper::count($cred);

    for ($i = 0; $i < $iMax; $i++) {
      Setting::where('type', $keys[$i])->update(['description' => $values[$i]]);
    }
//    School::updateOrCreate(
//      [$this->school['name']],
//      [
//      'name' => $this->school['name'],
//      'address' => $this->school['address'],
//      'phone_number1' => $this->school['phone_number1'],
//      'phone_number2' => $this->school['phone_number2'] ?? '',
//      'school_logo' => $this->school['school_logo'] ?? '',
//    ]);

    session()->flash('message', 'School Details Updated Successfully');
  }
}
