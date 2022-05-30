<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClassSubjectTeacher extends Model
{
	use HasFactory;

	public $timestamps = false;

	protected $fillable = [
		'class_room_id', 'subject_id', 'teacher_id'
	];

	public function subject(): BelongsTo
	{
		return $this->belongsTo(Subject::class)->withDefault();
	}

	public function teacher(): BelongsTo
	{
		return $this->belongsTo(Teacher::class)->withDefault();
	}

	public function classroom(): BelongsTo
	{
		return $this->belongsTo(ClassRoom::class)->withDefault();
	}
}
