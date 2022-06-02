<?php

namespace App\Models;

use App\Traits\WithSearch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

	public function marks(): HasMany
    {
        return $this->hasMany(Mark::class);
    }
}
