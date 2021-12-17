<?php

// write scripts here

// create new terms when session is updated
use App\Models\Term;


if (!function_exists('create_terms')) {
  function create_terms()
  {
    Term::firstOrCreate([
      'name' => 'First Term',
      'session' => get_setting('current_session'),
    ]);

    Term::firstOrCreate([
      'name' => 'Second Term',
      'session' => get_setting('current_session'),
    ]);

    Term::firstOrCreate([
      'name' => 'Third Term',
      'session' => get_setting('current_session'),
    ]);
  }
}