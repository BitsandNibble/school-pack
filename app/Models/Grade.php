<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Grade extends Model
{
	use HasFactory;

	protected $guarded = [];

	public function class_type(): BelongsTo
	{
		return $this->belongsTo(ClassType::class)->withDefault();
	}
}
