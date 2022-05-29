<?php

namespace App\Http\Controllers\Principal;

use App\Models\Section;
use App\Models\ClassRoom;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;

class HomeController extends Controller
{

    public function getStudentsPerClass(ClassRoom $class): Factory|View|Application
    {
        return view('users.principal.class-student', compact('class'));
    }

    public function getSubjectsPerClass(ClassRoom $class): Factory|View|Application
    {
        return view('users.principal.class-subject', compact('class'));
    }

    public function getStudentsPerSection(ClassRoom $class, Section $section): Factory|View|Application
    {
        return view('users.principal.section-student', compact('class', 'section'));
    }
}
