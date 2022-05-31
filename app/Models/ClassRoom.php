<?php

namespace App\Models;

use App\Traits\WithSearch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ClassRoom extends Model
{
	use HasFactory, WithSearch;

	protected $guarded = [];

	public function subject_teachers(): BelongsToMany
	{
		return $this->belongsToMany(Teacher::class, 'class_subject_teachers', 'class_room_id');
		// return $this->belongsToMany(Teacher::class, 'class_subject_teacher', 'class_room_id', 'teacher_id')->withPivot('subject_id');
	}

	public function subjects(): BelongsToMany
	{
		return $this->belongsToMany(Subject::class, 'class_subject_teachers', 'class_room_id');
		// return $this->belongsToMany(Subject::class, 'class_subject_teacher', 'class_room_id', 'subject_id')->withPivot('teacher_id');
	}

	public function class_type(): BelongsTo
	{
		return $this->belongsTo(ClassType::class)->withDefault();
	}

	public function sections(): HasMany
	{
		return $this->hasMany(Section::class);
	}

	public function getNameAttribute($value): string
	{
		return strtoupper($value); // return all classes as UPPERCASE
	}
}
