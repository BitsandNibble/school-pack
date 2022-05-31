<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClassStudentSubject extends Model
{
	use HasFactory;

	protected $table = 'class_student_subjects';

	public $timestamps = false;

	protected $guarded = [];

	public function student(): BelongsTo
	{
		return $this->belongsTo(Student::class)->withDefault();
	}

	public function subject(): BelongsTo
	{
		return $this->belongsTo(Subject::class)->withDefault();
	}
}
