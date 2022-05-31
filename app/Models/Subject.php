<?php

namespace App\Models;

use Closure;
use App\Traits\WithSearch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @method static get()
 * @method static when($q, Closure $param)
 * @method static where(string $string, $id)
 * @method static find($subject_id)
 * @method static create(array $array)
 * @method static whereIn(string $string, $cst)
 */
class Subject extends Model
{
	use HasFactory, WithSearch;

	public $timestamps = false;

	protected $fillable = [
		'name', 'slug',
	];

	public function class_subjects(): BelongsToMany
	{
		return $this->belongsToMany(ClassRoom::class, 'class_student_subjects', 'subject_id');
    }
}
