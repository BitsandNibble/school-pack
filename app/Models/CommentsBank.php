<?php

namespace App\Models;

use App\Traits\WithSearch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CommentsBank extends Model
{
	use HasFactory;
	use WithSearch;

	public $timestamps = false;

	protected $guarded = [];
}
