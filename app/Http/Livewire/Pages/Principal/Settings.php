<?php

namespace App\Http\Livewire\Pages\Principal;

use App\Helpers\SP;
use App\Models\Setting;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class Settings extends Component
{
  use WithFileUploads;

  public $settings;
  public $school_logo;

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
//    'school_logo' => 'sometimes|image|max:2048',
    'school_logo' => 'sometimes',
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
    'school_logo' => 'logo',
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

    if ($credentials['school_logo'] !== null) {
      $logo = $this->handleLogoUpload($credentials['school_logo'], $credentials['settings']['school_name']);
      Setting::where('type', 'school_logo')->update(['description' => $logo]);
    }

    $cred = $credentials['settings'];

    $keys = array_keys($cred);
    $values = array_values($cred);
    $iMax = SP::count($cred);

    for ($i = 0; $i < $iMax; $i++) {
      Setting::where('type', $keys[$i])->update(['description' => $values[$i]]);
    }

    session()->flash('message', 'School Settings Updated Successfully');
  }

  public function handleLogoUpload($logo, $slug): string
  {
    $slug = Str::slug($slug, '_');
    $name = $slug . '.' . $logo->getClientOriginalExtension();
    $logo->storeAs('public/logos', $name);
    return $name;
  }
}
