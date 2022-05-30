<?php

namespace App\Http\Controllers\Teacher;

use App\Models\Section;
use App\Models\ClassRoom;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;

class HomeController extends Controller
{
    public function index(): Factory|View|Application
    {
        $sections = Section::where('teacher_id', auth('teacher')->id())
            ->with('classroom', 'teacher')->get();

        return view('users.teacher.index', compact('sections'));
    }

    public function getStudentsPerClassOrSection(ClassRoom $class, Section $section): Factory|View|Application
    {
        return view('users.teacher.class-student', compact('class', 'section'));
    }
}
