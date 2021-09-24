<?php

namespace App\Http\Livewire\Pages\Principal;

use App\Helpers\SP;
use App\Models\Setting;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class Settings extends Component
{
  use WithFileUploads;

  public $settings;

  protected array $rules = [
    'settings.school_name' => 'required|string',
    'settings.school_title' => 'required|string',
    'settings.current_session' => 'required|string',
    'settings.term_begins' => 'required|date',
    'settings.term_ends' => 'required|date',
    'settings.address' => 'required|string',
    'settings.school_mail' => 'sometimes|email',
    'settings.alt_mail' => 'sometimes|email',
    'settings.phone' => 'required|numeric',
    'settings.mobile' => 'numeric',
    'settings.school_logo' => 'sometimes|image|max:2048',
  ];

  protected array $validationAttributes = [
    'settings.school_name' => 'school name',
    'settings.school_title' => 'school title',
    'settings.current_session' => 'current session',
    'settings.term_begins' => 'term begins',
    'settings.term_ends' => 'term ends',
    'settings.address' => 'address',
    'settings.school_mail' => 'email',
    'settings.alt_mail' => 'email',
    'settings.phone' => 'phone number',
    'settings.mobile' => 'mobile number',
    'settings.school_logo' => 'logo',
  ];

  public function render(): Factory|View|Application
  {
    $sets = Setting::get();
    $s['set'] = $sets->flatMap(function ($sets) {
      return [$sets->type => $sets->description];
    });
    $this->settings = $s['set'];

    return view('livewire.pages.principal.settings', $s);
  }

  public function store(): void
  {
    $credentials = $this->validate();
    foreach ($credentials as $cred) {
    }

    $keys = array_keys($cred);
    $values = array_values($cred);
    $iMax = SP::count($cred);

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
