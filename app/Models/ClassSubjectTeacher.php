<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClassSubjectTeacher extends Model
{
	use HasFactory;

	public $timestamps = false;

	protected $guarded = [];

	public function subject(): BelongsTo
	{
		return $this->belongsTo(Subject::class)->withDefault();
	}

	public function teacher(): BelongsTo
	{
		return $this->belongsTo(Teacher::class)->withDefault();
	}

	public function class_room(): BelongsTo
	{
		return $this->belongsTo(ClassRoom::class)->withDefault();
	}
}
