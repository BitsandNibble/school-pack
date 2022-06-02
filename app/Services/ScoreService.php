<?php

namespace App\Services;

use App\Models\Mark;
use App\Models\Term;
use App\Models\Student;
use App\Models\ClassRoom;
use App\Models\ExamRecord;

class ScoreService
{
	public function createScores($data)
	{
		// add records to marks & exam_records table
		$students = Student::query()->whereHas('class_subjects', function ($query) use ($data) {
			$query->where([
				'subject_id'    => $data['subject_id'],
				'class_room_id' => $data['class_id']
			]);
		})->get(['id']);

		$year = Term::query()->find($data['term_id'])->session;

		foreach ($students as $student) {
			Mark::query()->firstOrCreate([
				'student_id'    => $student->id,
				'subject_id'    => $data['subject_id'],
				'class_room_id' => $data['class_id'],
				'section_id'    => $data['section_id'],
				'term_id'       => $data['term_id'],
				'year'          => $year,
			]);

			ExamRecord::query()->firstOrCreate([
				'student_id'    => $student->id,
				'class_room_id' => $data['class_id'],
				'section_id'    => $data['section_id'],
				'term_id'       => $data['term_id'],
				'year'          => $year,
			]);
		}
	}

	public function updateScores($data, $cred)
	{
		$all_student_ids = [];

		// get class_type_id to use for assigning grades
		$class_type_id = ClassRoom::query()->find($data['class_room_id'])->class_type_id;

		// fetch data from mark table so that data can be inserted to specific students
		$marks = Mark::query()->where($data)->with('grade')->get();

		// update records in mark table
		foreach ($marks as $index => $mark) {
			// insert each student id into the array, to be used
			// for inserting data into the exam_records table
			array_push($all_student_ids, $mark->student_id);

			$ca1   = $cred[$index]['ca1'] ?? null;
			$ca2   = $cred[$index]['ca2'] ?? null;
			$tca   = $ca1 + $ca2;
			$exam  = $cred[$index]['exam_score'] ?? null;
			$total = $tca + $exam;

			// get grade
			$grade = get_grade($total, $class_type_id);

			// get subject position
			$sub_pos = get_subject_position($mark->student_id, $data['term_id'], $data['class_room_id'], $data['subject_id'], $data['year']);

			$mark->update([
				'ca1'              => $ca1,
				'ca2'              => $ca2,
				'total_ca'         => $tca,
				'exam_score'       => $exam,
				'total_score'      => $total,
				'grade_id'         => $grade?->id,
				'subject_position' => $sub_pos
			]);
		}

		// update data in exam_records table
		foreach ($all_student_ids as $student_id) {
			ExamRecord::query()->where(['student_id' => $student_id, 'term_id' => $data['term_id']])
				->update([
					'total'         => get_exam_total($data['term_id'], $student_id, $data['class_room_id'], $data['year']),
					'average'       => get_exam_avg($data['term_id'], $student_id, $data['class_room_id'], $data['year']),
					'class_average' => get_class_avg($data['term_id'], $data['class_room_id'], $data['year']),
					'position'      => get_student_position($data['term_id'], $student_id, $data['class_room_id'], $data['year']),
				]);
		}
	}
}
