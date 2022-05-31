<?php

namespace App\Models;

use Closure;
use App\Traits\WithSearch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subject extends Model
{
	use HasFactory, WithSearch;

	public $timestamps = false;

	protected $guarded = [];

	public function class_subjects(): BelongsToMany
	{
		return $this->belongsToMany(ClassRoom::class, 'class_student_subjects', 'subject_id');
	}
}
