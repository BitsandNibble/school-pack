<?php

use App\Http\Livewire\Principal\Classes;
use App\Http\Livewire\Principal\Student;
use App\Http\Livewire\Principal\Students;
use App\Http\Livewire\Principal\Teachers;
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
Route::group(['prefix' => 'principal', 'as' => 'principal.'], function () {
  Route::view('/', 'principal.index')->name('home');
  Route::get('teachers', Teachers::class)->name('teachers');
  Route::get('students', Students::class)->name('students');
  Route::get('student', Student::class)->name('student');
  Route::get('classes', Classes::class)->name('classes');
  Route::view('results', 'principal.results')->name('results');
  Route::view('result', 'principal.result')->name('result');
  Route::view('subjects', 'principal.subjects')->name('subjects');
});
Route::view('login', 'auth.login');
