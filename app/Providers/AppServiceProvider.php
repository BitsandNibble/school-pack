<?php

namespace App\Providers;

use App\Models\Section;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      view()->composer(
        'layouts.side-nav',
        function ($view) {
          $view->with('sec',
            Section::where('teacher_id', auth('teacher')->id())
              ->with('class_room', 'teacher')->get()
          );
        }
      );
    }
}
