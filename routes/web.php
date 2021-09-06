<?php

use App\Http\Controllers\Principal\HomeController;
use App\Http\Livewire\Component\Login;
use App\Http\Livewire\Pages\Principal\Classes;
use App\Http\Livewire\Pages\Principal\Settings;
use App\Http\Livewire\Pages\Principal\Students;
use App\Http\Livewire\Pages\Principal\Teachers;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
  return view('welcome');
});

Route::view('components', 'components')->name('components');

Route::group(['middleware' => 'auth:principal', 'prefix' => 'principal', 'as' => 'principal'], function () {
  Route::view('/', 'principal.index')->name('.home');
  Route::get('teachers', Teachers::class)->name('.teachers');
  Route::get('students', Students::class)->name('.students');
  Route::get('classes', Classes::class)->name('.classes');
  Route::get('classes/{classname:name}', [HomeController::class, 'getStudentsPerClass'])->name('.classes.students');
  Route::view('results', 'principal.results')->name('.results');
  Route::view('result', 'principal.result')->name('.result');
  Route::view('subjects', 'principal.subjects')->name('.subjects');
  Route::get('settings', Settings::class)->name('.settings');
});
Route::get('login', Login::class)->middleware('guest:principal')->name('login');
// Route::view('login', 'auth.login')->name('login');
