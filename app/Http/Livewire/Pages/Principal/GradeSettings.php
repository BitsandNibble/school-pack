<?php

namespace App\Http\Livewire\Pages\Principal;

use App\Models\Setting;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Contracts\Foundation\Application;

class GradeSettings extends Component
{
    use LivewireAlert;

    public $settings;

    protected array $rules = [
        'settings.ca1' => 'required|numeric',
        'settings.ca2' => 'required|numeric',
        'settings.exam' => 'required|numeric',
    ];

    protected array $validationAttributes = [
        'settings.ca1' => 'first CA',
        'settings.ca2' => 'second CA',
        'settings.exam' => 'exam score',
    ];

    public function render(): Factory|View|Application
    {
        $sets = Setting::get();
        $s['set'] = $sets->flatMap(function ($sets) {
            return [$sets->type => $sets->description];
        });
        $this->settings = $s['set'];

        return view('livewire.pages.principal.grade-settings', $s);
    }

    public function store(): void
    {
        $credentials = $this->validate();
        foreach ($credentials as $cred) {
        }

        $keys = array_keys($cred);
        $values = array_values($cred);
        $iMax = count($cred);

        for ($i = 0; $i < $iMax; $i++) {
            Setting::where('type', $keys[$i])->update(['description' => $values[$i]]);
        }

        $this->alert('success', 'Grade Settings Updated Successfully');
    }
}
