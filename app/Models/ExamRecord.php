<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExamRecord extends Model
{
	use HasFactory;

	protected $guarded = [];

	public function term(): BelongsTo
	{
		return $this->belongsTo(Term::class)->withDefault();
	}

	protected $casts = [
		'af' => 'array',
		'ps' => 'array'
	];
}
