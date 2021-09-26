<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Principal\HomeController as PrincipalHomeController;
use App\Http\Controllers\Teacher\HomeController as TeacherHomeController;
use App\Http\Livewire\Pages\Principal\Classes;
use App\Http\Livewire\Pages\Principal\Grades;
use App\Http\Livewire\Pages\Principal\Profile as PrincipalProfile;
use App\Http\Livewire\Pages\Principal\Sections;
use App\Http\Livewire\Pages\Principal\Settings;
use App\Http\Livewire\Pages\Principal\Students;
use App\Http\Livewire\Pages\Principal\Subjects;
use App\Http\Livewire\Pages\Principal\Teachers;
use App\Http\Livewire\Pages\Teacher\Profile as TeacherProfile;
use App\Http\Livewire\Pages\Teacher\Subjects as TeacherSubjects;
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
  Route::view('/', 'users.principal.index')->name('.home');
  Route::get('teachers', Teachers::class)->name('.teachers');
  Route::get('students', Students::class)->name('.students');
  Route::get('classes', Classes::class)->name('.classes');
  Route::get('sections', Sections::class)->name('.sections');
  Route::get('classes/{classname:slug}', [PrincipalHomeController::class, 'getStudentsPerClass'])->name('.classes.students');
  Route::get('class/{classname:slug}/{section:name}', [PrincipalHomeController::class, 'getStudentsPerSection'])->name('.sections.students');
  Route::view('results', 'users.principal.results')->name('.results');
  Route::view('result', 'users.principal.result')->name('.result');
  Route::get('subjects', Subjects::class)->name('.subjects');
  Route::get('subjects/{classname:name}', [PrincipalHomeController::class, 'getSubjectsPerClass'])->name('.classes.subjects');
  Route::get('settings', Settings::class)->name('.settings');
  Route::get('profile', PrincipalProfile::class)->name('.profile');
  Route::get('grades', Grades::class)->name('.grades');
});

Route::group(['middleware' => 'auth:teacher', 'prefix' => 'teacher', 'as' => 'teacher'], function () {
  Route::get('/', [TeacherHomeController::class, 'index'])->name('.home');
  Route::get('profile', TeacherProfile::class)->name('.profile');
  Route::get('subjects', TeacherSubjects::class)->name('.subjects');
  Route::get('{classname:slug}/{section:name}', [TeacherHomeController::class, 'getStudentsPerClassOrSection'])->name('.classes.students');
});

Route::get('login', [AuthController::class, 'create'])->middleware(['guest:principal', 'guest:teacher'])
  ->name('login');
Route::post('login', [AuthController::class, 'store'])->middleware('guest');
Route::get('logout', [AuthController::class, 'destroy'])->name('logout');