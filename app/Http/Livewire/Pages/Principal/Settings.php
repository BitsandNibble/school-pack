<?php

namespace App\Http\Livewire\Pages\Principal;

use App\Models\Setting;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class Settings extends Component
{
  use WithFileUploads;
  use LivewireAlert;

  public $settings;
  public $school_logo;
  public $year;

  protected $listeners = ['getYear0', 'getYear1'];

  protected array $rules = [
    'settings.school_name' => 'required|string',
    'settings.school_title' => 'required|string',
    'settings.current_session' => '',
    'year.0' => 'required',
    'year.1' => 'required',
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
    'year.0' => 'year',
    'year.1' => 'year',
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

    $session = $this->settings->toArray()['current_session']; // get session
    $this->year = explode('-', $session); // split session to get the individual years

    return view('livewire.pages.principal.settings', $s);
  }

  public function store(): void
  {
    $credentials = $this->validate();

    if ($credentials['school_logo'] !== null) {
      $logo = $this->handleLogoUpload($credentials['school_logo'], $credentials['settings']['school_name']);
      Setting::where('type', 'school_logo')->update(['description' => $logo]);
    }

    $cred = $credentials['settings']; // get values after submitting
    $changed_session = ["current_session" => implode(' - ', $this->year)]; // get the session from the two years selected

    $new_cred = array_merge($cred, $changed_session); // get the new credentials by merging the new session

    // get array key and value from the new credentials
    $keys = array_keys($new_cred);
    $values = array_values($new_cred);
    $iMax = count($new_cred);

    for ($i = 0; $i < $iMax; $i++) {
      Setting::where('type', $keys[$i])->update(['description' => $values[$i]]);
    }

    $this->alert('success', 'School Settings Updated Successfully');
  }

  public function handleLogoUpload($logo, $slug): string
  {
    $slug = Str::slug($slug, '_');
    $name = $slug . '.' . $logo->getClientOriginalExtension();
    $logo->storeAs('public/logos', $name);
    return $name;
  }
}
