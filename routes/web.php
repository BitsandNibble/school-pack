<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Livewire\Components\Scores;
use App\Http\Livewire\Components\Promote;
use App\Http\Controllers\GeneralController;
use App\Http\Livewire\Components\MarkSheet;
use App\Http\Livewire\Pages\Principal\Terms;
use App\Http\Livewire\Pages\Student\Payment;
use App\Http\Livewire\Components\NoticeBoard;
use App\Http\Livewire\Pages\Principal\Grades;
use App\Http\Livewire\Pages\Principal\Skills;
use App\Http\Livewire\Pages\Principal\Classes;
use App\Http\Livewire\Pages\Accountant\Debtors;
use App\Http\Livewire\Pages\Principal\Sections;
use App\Http\Livewire\Pages\Principal\Students;
use App\Http\Livewire\Pages\Principal\Subjects;
use App\Http\Livewire\Pages\Principal\Teachers;
use App\Http\Livewire\Components\ManagePromotion;
use App\Http\Livewire\Components\TabulationSheet;
use App\Http\Livewire\Pages\Student\SelectSession;
use App\Http\Livewire\Pages\Accountant\CreatePayment;
use App\Http\Livewire\Pages\Accountant\ManagePayment;
use App\Http\Livewire\Pages\Accountant\StudentPayment;
use App\Http\Livewire\Pages\Principal\Settings\School;
use App\Http\Livewire\Pages\Principal\Settings\Comments;
use App\Http\Livewire\Pages\Student\Profile as StudentProfile;
use App\Http\Livewire\Pages\Teacher\Profile as TeacherProfile;
use App\Http\Livewire\Pages\Teacher\Subjects as TeacherSubjects;
use App\Http\Livewire\Pages\Principal\Profile as PrincipalProfile;
use App\Http\Livewire\Pages\Accountant\Profile as AccountantProfile;
use App\Http\Controllers\Teacher\HomeController as TeacherHomeController;
use App\Http\Controllers\Principal\HomeController as PrincipalHomeController;
use App\Http\Controllers\Accountant\HomeController as AccountantHomeController;

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
    Route::get('settings/school', School::class)->name('.settings.school');
    Route::get('settings/comments', Comments::class)->name('.settings.comments');
    Route::get('profile', PrincipalProfile::class)->name('.profile');
    Route::get('notice-board', NoticeBoard::class)->name('.notice-board');

    //  grading
    Route::get('grading/terms', Terms::class)->name('.terms');
    Route::get('grading/grades', Grades::class)->name('.grades');
    Route::get('grading/scores', Scores::class)->name('.scores');
    Route::get('grading/skills', Skills::class)->name('.skills');

    //  promotions
    Route::get('students/promote', Promote::class)->name('.students.promote');
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
    Route::get('mark-sheet/select-session', SelectSession::class)->name('.select-session');
    Route::get('payments/students-payment', Payment::class)->name('.payment');
});

// accountant route
Route::group(['middleware' => 'auth:accountant', 'prefix' => 'accountant', 'as' => 'accountant'], function () {
    Route::view('/', 'users.accountant.index')->name('.home');
    Route::get('profile', AccountantProfile::class)->name('.profile');
});

// payment route
Route::group(['middleware' => 'auth:accountant,principal'], function () {
    Route::get('payments/create-payment', CreatePayment::class)->name('create-payment');
    Route::get('payments/manage-payment', ManagePayment::class)->name('manage-payment');
    Route::get('payments/students-payment', StudentPayment::class)->name('student-payment');
    Route::get('payments/invoice/{student_id}/{session?}', [AccountantHomeController::class, 'getStudentId'])->name('payment.invoice');
    Route::get('payments/debtors', Debtors::class)->name('payment.debtors');
});

// print route
Route::group(['middleware' => 'auth:teacher,principal,student'], function () {
    Route::get('results/mark-sheet/show/{id}/{session}/{class}', [GeneralController::class, 'getMarksheetYear'])->name('result.marksheet.show');
    Route::get('marks/print/{id}/{exam_id}/{year}', [GeneralController::class, 'printMarkSheet'])->name('print_marksheet');
    Route::get('marks/print/{exam_id}/{class}', [GeneralController::class, 'printTabulationSheet'])->name('print_tabulation_sheet');
    Route::get('payments/receipts/{pr_id}', [GeneralController::class, 'printReceipt'])->name('print_invoice');
});

// general route
Route::group(['middleware' => 'auth:accountant,principal,student,teacher'], function () {
    Route::get('notice/{id}', [GeneralController::class, 'notice'])->name('notice');
});

// login route
Route::get('login', [AuthController::class, 'create'])->middleware(['guest:principal', 'guest:teacher'])
    ->name('login');
Route::post('login', [AuthController::class, 'store'])->middleware('guest');
Route::get('logout', [AuthController::class, 'destroy'])->name('logout');