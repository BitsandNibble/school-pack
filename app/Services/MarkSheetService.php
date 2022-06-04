<?php

namespace App\Services;

use App\Models\Mark;
use App\Models\Student;
use App\Models\ClassRoom;
use App\Models\ExamRecord;

class MarkSheetService
{
    public function getMarkSheetYear($student_id, $session, $class_id): array
    {
        $d['year'] = $session;

        $d['student'] = Student::where('id', $student_id)
            ->with('class_room', 'section')
            ->first();

        $d['exam_records'] = $exr = ExamRecord::where(['year' => $session, 'student_id' => $student_id, 'class_room_id' => $class_id])
            ->with('term')
            ->get();

        $d['marks'] = Mark::where(['year' => $session, 'student_id' => $student_id, 'class_room_id' => $class_id])
            ->with('subject', 'grade')
            ->get();

        $d['ca1_limit'] = get_setting('ca1') ?: null;
        $d['ca2_limit'] = get_setting('ca2') ?: null;
        $d['exam_limit'] = get_setting('exam') ?: null;
        $d['total'] = $d['ca1_limit'] + $d['ca2_limit'] + $d['exam_limit'];

        return $d;
    }
}