<?php

use App\Models\Section;
use App\Models\Setting;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\ClassSubjectTeacher;


// check if teacher has access to view tabulation-sheet page
if (!function_exists('check_teacher_tabulation_sheet_access')) {
	function check_teacher_tabulation_sheet_access(): void
	{
		if (auth('teacher')->user() && empty(ClassSubjectTeacher::query()->where('teacher_id', auth('teacher')->id())
			->get()->filter())) {
			abort(403);
		}
	}
}


// check if teacher has access to view marksheet page
if (!function_exists('check_teacher_marksheet_access')) {
	function check_teacher_marksheet_access(): void
	{
		if (auth('teacher')->user() && empty(Section::where('teacher_id', auth('teacher')->id())
			->get()->filter())) {
			abort(403);
		}
	}
}


// get all settings from DB
if (!function_exists('get_setting')) {
	function get_setting($type)
	{
		return Setting::where('type', $type)->first()->description;
	}
}


// get first word from a sentence/string
if (!function_exists('get_first_word')) {
	function get_first_word(string $string): string
	{
		return explode(' ', ucfirst(trim($string)))[0];
	}
}


// get total number of students from DB
if (!function_exists('total_students')) {
	function total_students()
	{
		return Student::get()->count();
	}
}


// get total number of teachers from DB
if (!function_exists('total_teachers')) {
	function total_teachers()
	{
		return Teacher::get()->count();
	}
}


// add suffix to position(subject or student)
if (!function_exists('get_suffix')) {
	function get_suffix($number): ?string
	{
		if ($number < 1) {
			return NULL;
		}
		$ends = ['th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th'];

		if ((($number % 100) >= 11) && (($number % 100) <= 13)) {
			return $number . '<sup>th</sup>';
		}
		return $number . '<sup>' . $ends[$number % 10] . '</sup>';
	}
}


// get school logo from DB or return default one
if (!function_exists('get_school_logo')) {
	function get_school_logo(): string
	{
		$logo = Setting::get()->toArray()[10]['description'];

		if ($logo !== "") {
			return asset('storage/logos/' . $logo);
		}
		return asset('assets/_images/school_logo.jpg');
	}
}


// check if term is locked
if (!function_exists('is_term_locked')) {
	function is_term_locked($term): string
	{
		return $term->locked === 1 ? 'disabled' : '';
	}
}


// display an array of current session & future sessions
if (!function_exists('all_sessions')) {
	function all_sessions(): array
	{
		$current_session = get_setting('current_session');
		$year            = explode(' - ', $current_session);
		$year_one        = $year[0];
		$year_two        = $year[1];

		return [
			$current_session, ++$year_one . ' - ' . ++$year_two,
		];
	}
}
