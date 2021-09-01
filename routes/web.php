<?php

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
  Route::view('teachers', 'principal.teachers')->name('teachers');
  Route::view('students', 'principal.students')->name('students');
  Route::view('student', 'principal.student')->name('student');
  Route::view('classes', 'principal.classes')->name('classes');
  Route::view('results', 'principal.results')->name('results');
  Route::view('result', 'principal.result')->name('result');
  Route::view('subjects', 'principal.subjects')->name('subjects');
});
Route::view('login', 'auth.login');
