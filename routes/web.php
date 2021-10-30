<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\Principal\HomeController as PrincipalHomeController;
use App\Http\Controllers\Teacher\HomeController as TeacherHomeController;
use App\Http\Livewire\Components\ManagePromotion;
use App\Http\Livewire\Components\MarkSheet;
use App\Http\Livewire\Components\Promotion;
use App\Http\Livewire\Components\Scores;
use App\Http\Livewire\Components\TabulationSheet;
use App\Http\Livewire\Pages\Accountant\Profile as AccountantProfile;
use App\Http\Livewire\Pages\Principal\Classes;
use App\Http\Livewire\Pages\Principal\Exams;
use App\Http\Livewire\Pages\Principal\Grades;
use App\Http\Livewire\Pages\Principal\Profile as PrincipalProfile;
use App\Http\Livewire\Pages\Principal\Sections;
use App\Http\Livewire\Pages\Principal\Settings;
use App\Http\Livewire\Pages\Principal\Skills;
use App\Http\Livewire\Pages\Principal\Students;
use App\Http\Livewire\Pages\Principal\Subjects;
use App\Http\Livewire\Pages\Principal\Teachers;
use App\Http\Livewire\Pages\Student\Profile as StudentProfile;
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

// principal route
Route::group(['middleware' => 'auth:principal', 'prefix' => 'principal', 'as' => 'principal'], function () {
  Route::view('/', 'users.principal.index')->name('.home');
  Route::get('teachers', Teachers::class)->name('.teachers');
  Route::get('students/view', Students::class)->name('.students');
  Route::get('classes', Classes::class)->name('.classes');
  Route::get('sections', Sections::class)->name('.sections');
  Route::get('classes/{classname:slug}', [PrincipalHomeController::class, 'getStudentsPerClass'])->name('.classes.students');
  Route::get('class/{classname:slug}/{section}', [PrincipalHomeController::class, 'getStudentsPerSection'])->name('.sections.students');
  Route::get('results/tabulated', TabulationSheet::class)->name('.result.tabulated');
  Route::get('results/mark-sheet', MarkSheet::class)->name('.result.marksheet');
  Route::get('subjects', Subjects::class)->name('.subjects');
  Route::get('subjects/{classname:name}', [PrincipalHomeController::class, 'getSubjectsPerClass'])->name('.classes.subjects');
  Route::get('settings', Settings::class)->name('.settings');
  Route::get('profile', PrincipalProfile::class)->name('.profile');

  //  grading
  Route::get('grading/exams', Exams::class)->name('.exams');
  Route::get('grading/grades', Grades::class)->name('.grades');
  Route::get('grading/scores', Scores::class)->name('.scores');
  Route::get('grading/skills', Skills::class)->name('.skills');

  //  promotions
  Route::get('students/promotion', Promotion::class)->name('.students.promotion');
  Route::get('students/manage-promotion', ManagePromotion::class)->name('.students.manage-promotion');
});

// teacher route
Route::group(['middleware' => 'auth:teacher', 'prefix' => 'teacher', 'as' => 'teacher'], function () {
  Route::get('/', [TeacherHomeController::class, 'index'])->name('.home');
  Route::get('profile', TeacherProfile::class)->name('.profile');
  Route::get('subjects', TeacherSubjects::class)->name('.subjects');
  Route::get('grading/scores', Scores::class)->name('.scores');
  Route::get('results/tabulated', TabulationSheet::class)->name('.result.tabulated');
  Route::get('results/mark-sheet', MarkSheet::class)->name('.result.marksheet');
  Route::get('{classname:slug}/{section}', [TeacherHomeController::class, 'getStudentsPerClassOrSection'])->name('.classes.students');
});

// student route
Route::group(['middleware' => 'auth:student', 'prefix' => 'student', 'as' => 'student'], function () {
  Route::view('/', 'users.student.index')->name('.home');
  Route::get('profile', StudentProfile::class)->name('.profile');
});

// accountant route
Route::group(['middleware' => 'auth:accountant', 'prefix' => 'accountant', 'as' => 'accountant'], function () {
  Route::view('/', 'users.accountant.index')->name('.home');
  Route::get('profile', AccountantProfile::class)->name('.profile');
});

// print route
Route::get('results/mark-sheet/show/{id}', [GeneralController::class, 'getStudentId'])->name('result.marksheet.select_year');
Route::post('results/mark-sheet/show/{id}', [GeneralController::class, 'getMarksheetYear'])->name('result.marksheet.show');
Route::get('marks/print/{id}/{exam_id}/{year}', [GeneralController::class, 'printMarkSheet'])->name('print_marksheet');
Route::get('marks/print/{exam_id}/{class}', [GeneralController::class, 'printTabulationSheet'])->name('print_tabulation_sheet');

// login route
Route::get('login', [AuthController::class, 'create'])->middleware(['guest:principal', 'guest:teacher'])
  ->name('login');
Route::post('login', [AuthController::class, 'store'])->middleware('guest');
Route::get('logout', [AuthController::class, 'destroy'])->name('logout');